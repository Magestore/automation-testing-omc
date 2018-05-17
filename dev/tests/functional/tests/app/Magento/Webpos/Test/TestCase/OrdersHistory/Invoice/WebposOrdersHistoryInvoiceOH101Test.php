<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/31/2018
 * Time: 4:57 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\Invoice;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertInvoicePopupCorrect;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrdersHistoryInvoiceOH101Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var AssertInvoicePopupCorrect
     */
    protected $assertInvoicePopupCorrect;

    /**
     * Prepare data.
     *
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        // Change TaxRate
        $taxRate = $fixtureFactory->createByCode('taxRate', ['dataset'=> 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);

        // Add Customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();

        return [
            'customer' => $customer,
            'taxRate' => $taxRate->getRate()
        ];
    }



    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertInvoicePopupCorrect $assertInvoicePopupCorrect
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertInvoicePopupCorrect = $assertInvoicePopupCorrect;
    }


    public function test(
        Customer $customer,
        $products,
        $configData,
        $taxRate,
        $addDiscount = false,
        $discountAmount = null,
        $createInvoice = true,
        $shipped = false
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        // Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
        )->run();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();

        // Change customer in cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();

        // Add Discount
        if ($addDiscount) {
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
            sleep(1);
            self::assertTrue(
                $this->webposIndex->getCheckoutDiscount()->isVisible(),
                'CategoryRepository - TaxClass page - Delete TaxClass - Add discount popup is not shown'
            );
            $this->webposIndex->getCheckoutDiscount()->setDiscountPercent($discountAmount);
            $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        }

        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);
        $this->webposIndex->getCheckoutShippingMethod()->clickFlatRateFixedMethod();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => $createInvoice,
                'shipped' => $shipped
            ]
        )->run();

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        sleep(2);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();

        // Assert Tax Amount in Order History Invoice
        $products2 = array();
        foreach ($products as $item) {
            $productName =  $item['product']->getName();
            $product = array(
                'Product' => $productName,
                'Original Price' => $this->webposIndex->getOrderHistoryOrderViewContent()->getOriginalPriceOfProduct($productName)->getText(),
                'Price' => $this->webposIndex->getOrderHistoryOrderViewContent()->getPriceOfProduct($productName)->getText(),
                'Qty' => $this->webposIndex->getOrderHistoryOrderViewContent()->getQtyOfProduct($productName)->getText(),
                'Subtotal' => $this->webposIndex->getOrderHistoryOrderViewContent()->getSubTotalOfProduct($productName),
                'Tax Amount' => $this->webposIndex->getOrderHistoryOrderViewContent()->getTaxAmountOfProduct($productName),
                'Discount Amount' => $this->webposIndex->getOrderHistoryOrderViewContent()->getDiscountAmountOfProduct($productName),
                'Row Total' => $this->webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName),
            );
            array_push($products2, $product);
        }
        $labels = array(
            'Subtotal' => $this->webposIndex->getOrderHistoryOrderViewFooter()->getSubtotal(),
            'Shipping' => $this->webposIndex->getOrderHistoryOrderViewFooter()->getShipping(),
            'Tax' => $this->webposIndex->getOrderHistoryOrderViewFooter()->getTax(),
            'Discount' => $this->webposIndex->getOrderHistoryOrderViewFooter()->getDiscount(),
            'Grand Total' => $this->webposIndex->getOrderHistoryOrderViewFooter()->getGrandTotal(),
            'Total Paid' => $this->webposIndex->getOrderHistoryOrderViewFooter()->getTotalPaid(),
        );

        $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
        $this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
//        $this->assertInvoicePopupCorrect->processAssert($this->webposIndex, $products2, $labels);
        return [
            'products' => $products2,
            'labels' => $labels
        ];
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();
    }
}