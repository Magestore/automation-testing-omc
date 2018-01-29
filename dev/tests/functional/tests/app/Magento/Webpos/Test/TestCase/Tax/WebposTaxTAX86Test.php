<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/16/2018
 * Time: 1:09 PM
 */

namespace Magento\Webpos\Test\TestCase\Tax;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Tax\Test\Fixture\TaxRule;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\Tax\AssertProductPriceOnRefundPopupWithApplyDiscountOnPriceIncludingTax;
use Magento\Webpos\Test\Constraint\Tax\AssertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountAndDiscountAmountWithApplyDiscountOnPriceIncludingTax;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnCartPageAndCheckoutPage;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnCartPageAndCheckoutPageWithApplyDiscountOnPriceExcludingTax;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposTaxTAX86Test extends Injectable
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
     * @var TaxRule $caTaxRule
     */
    protected $caTaxRule;

    /**
     * @var AssertProductPriceOnRefundPopupWithApplyDiscountOnPriceIncludingTax
     */
    protected $assertProductPriceOnRefundPopupWithApplyDiscountOnPriceIncludingTax;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
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
        // Config system value
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();

        //Create California tax rule
        $taxRule = $fixtureFactory->createByCode('taxRule', ['dataset'=> 'CA_rule']);
        $taxRule->persist();
        $this->caTaxRule = $taxRule;
        $caTaxRate = $this->caTaxRule->getDataFieldConfig('tax_rate')['source']->getFixture();

        // Change TaxRate
        $miTaxRate = $fixtureFactory->createByCode('taxRate', ['dataset'=> 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($miTaxRate);

        // Add Customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();

        return [
            'customer' => $customer,
            'currentTaxRate' => $miTaxRate->getRate(),
            'originTaxRate' => $caTaxRate[0]->getRate()
        ];
    }


    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertProductPriceOnRefundPopupWithApplyDiscountOnPriceIncludingTax $assertProductPriceOnRefundPopupWithApplyDiscountOnPriceIncludingTax,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertProductPriceOnRefundPopupWithApplyDiscountOnPriceIncludingTax = $assertProductPriceOnRefundPopupWithApplyDiscountOnPriceIncludingTax;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $shippingTaxRate
     */
    public function test(
        Customer $customer,
        $products,
        $originTaxRate,
        $currentTaxRate,
        $addDiscount = false,
        $discountPercent = null,
        $expectStatus = 'Closed'
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        // Config [Apply Discount On Prices] = Including tax
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'apply_discount_on_prices_including_tax']
        )->run();
        // Config [Catalog Prices] = Including tax & [Enable Cross Border Trade] = No
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'including_tax_and_disable_cross_border_trade']
        )->run();
        // Config Origin shipping California
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'origin_shipping_california']
        )->run();
        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();
        // Change customer in cart meet Michigan Tax
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
            $this->webposIndex->getCheckoutDiscount()->setDiscountPercent($discountPercent);
            $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        }
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => true,
                'shipped' => true
            ]
        )->run();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        $orderId = str_replace('#' , '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        sleep(2);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {}
        self::assertEquals(
            $orderId,
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
            "Order Content - Order Id is wrong"
            . "\nExpected: " . $orderId
            . "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
        );
        // Refund
        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $this->webposIndex->getOrderHistoryAddOrderNote()->openRefundPopup();
        $actualProductPrice = substr($this->webposIndex->getOrderHistoryRefund()->getItemPrice($products[0]['product']->getName()),1);
        $this->assertProductPriceOnRefundPopupWithApplyDiscountOnPriceIncludingTax
            ->processAssert($products, $originTaxRate, $currentTaxRate, $actualProductPrice);
        // Refund successfully
        $this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
        $this->webposIndex->getModal()->getOkButton()->click();
    }

    public function tearDown()
    {
        $this->objectManager->create('Magento\Webpos\Test\Handler\TaxRule\Curl')->persist($this->caTaxRule);
        // Config system value
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();
    }
}