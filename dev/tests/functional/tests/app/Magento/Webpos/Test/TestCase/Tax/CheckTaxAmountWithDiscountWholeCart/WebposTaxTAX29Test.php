<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/10/2018
 * Time: 11:11 AM
 */

namespace Magento\Webpos\Test\TestCase\Tax\CheckTaxAmountWithDiscountWholeCart;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Swatches\Test\Fixture\ConfigurableProduct;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnOnHoldOrderPage;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnCartPageAndCheckoutPage;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnOrderHistoryInvoice;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 *  * Preconditions:
 * 1. Create customer
 * 2. Create products
 *
 * Test Flow:
 * 1. LoginTest Web POS as staff
 * 2. Add some taxable products
 * 3. Select a customer to meet tax condition
 * 4. Add discount for whole cart
 * 5. Click "Cart"
 * 6. Place order with: [Create invoice]: off
 * 7. Go to Order detail
 * 8. Click on [Invoice] button
 * 9. Check tax amount
 */

/**
 * Class WebposTaxTAX29Test
 * @package Magento\Webpos\Test\TestCase\Tax
 */
class WebposTaxTAX29Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var AssertTaxAmountOnOnHoldOrderPage $assertTaxAmountOnOnHoldOrderPage
     */
    protected $assertTaxAmountOnOnHoldOrderPage;

    /**
     * @var AssertTaxAmountOnCartPageAndCheckoutPage $assertTaxAmountOnCartPageAndCheckoutPage
     */
    protected $assertTaxAmountOnCartPageAndCheckoutPage;

    /**
     * @var AssertTaxAmountOnOrderHistoryInvoice $assertTaxAmountOnOrderHistoryInvoice
     */
    protected $assertTaxAmountOnOrderHistoryInvoice;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

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


    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertTaxAmountOnOnHoldOrderPage $assertTaxAmountOnOnHoldOrderPage
     * @param AssertTaxAmountOnCartPageAndCheckoutPage $assertTaxAmountOnCartPageAndCheckoutPage
     * @param AssertTaxAmountOnOrderHistoryInvoice $assertTaxAmountOnOrderHistoryInvoice
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertTaxAmountOnOnHoldOrderPage $assertTaxAmountOnOnHoldOrderPage,
        AssertTaxAmountOnCartPageAndCheckoutPage $assertTaxAmountOnCartPageAndCheckoutPage,
        AssertTaxAmountOnOrderHistoryInvoice $assertTaxAmountOnOrderHistoryInvoice,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertTaxAmountOnOnHoldOrderPage = $assertTaxAmountOnOnHoldOrderPage;
        $this->assertTaxAmountOnCartPageAndCheckoutPage = $assertTaxAmountOnCartPageAndCheckoutPage;
        $this->assertTaxAmountOnOrderHistoryInvoice = $assertTaxAmountOnOrderHistoryInvoice;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $configData
     * @param $taxRate
     * @param bool $addDiscount
     * @param null $discountAmount
     * @param bool $createInvoice
     * @param bool $shipped
     * @return array
     */
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

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => $createInvoice,
                'shipped' => $shipped
            ]
        )->run();

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        // End Place Order
        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        //End Assert Place Order Success
        $orderId = str_replace('#' , '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {}
        self::assertEquals(
            $orderId,
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
            "Order Content - Order Id is wrong"
            . "\nExpected: " . $orderId
            . "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
        );

        $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
        sleep(1);
        $this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();

        //Assert Tax Amount in Order History Invoice
        $this->assertTaxAmountOnOrderHistoryInvoice->processAssert($taxRate, $products, $this->webposIndex);

        // Invoice order successfully
        $this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();
        
        return [
            'products' => $products,
            'taxRate' => $taxRate
        ];
    }
}