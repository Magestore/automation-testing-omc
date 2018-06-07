<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/16/2018
 * Time: 9:00 AM
 */

namespace Magento\Webpos\Test\TestCase\Tax\CatalogPricesIncludingTaxCrossBorderTradeNo;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Tax\Test\Fixture\TaxRule;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\Tax\AssertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade;
use Magento\Webpos\Test\Constraint\Tax\AssertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Setting [Catalog Prices] = Including tax & [Enable Cross Border Trade] = No
 * Testcase TAX97 - Check tax amount on Order detail
 *
 * Precondition: Exist 2 tax rules: 1st tax rule meet to Shipping settings
 * 1. Go to Configuration >Sales >Tax >Tax Classes:
 * - [Catalog Prices] = Including tax
 * - [Enable Cross Border Trade] = No
 * Other fields: tick on [Use system value]
 * 2. Save config
 * 3. Go to Configuration > Sales> Tax >  Shipping settings:
 * - Input [Origin]
 * 4. Save config
 * On webpos:
 * 1. Login Webpos as a staff
 *
 * Steps
 * 1. Add a  product and select a customer to meet 2nd tax rule
 * 2. Place order successfully
 * 3. Go to Order detail page
 *
 * Acceptance Criteria
 * 3.
 * product_price_excl_tax = [product_price_incl_tax] / (1+ [default_tax_rate])
 * tax = [product_price_excl_tax] * [tax_rate_current]
 *
 * Class WebposTaxTAX63Test
 * @package Magento\Webpos\Test\TestCase\Tax\CatalogPricesIncludingTaxCrossBorderTradeNo
 */
class WebposTaxTAX63Test extends Injectable
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
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * @var AssertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade
     */
    protected $assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade;

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

        // Change TaxRate
        $taxRate = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);

        // Create CA Tax Rule
        $taxRule = $fixtureFactory->createByCode('taxRule', ['dataset' => 'CA_rule']);
        $taxRule->persist();
        $this->caTaxRule = $taxRule;

        // Add Customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();

        return [
            'customer' => $customer
        ];
    }


    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
        AssertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade $assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
        $this->assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade = $assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade;

    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $defaultTaxRate float
     * @param $currentTaxRate float
     */
    public function test(
        Customer $customer,
        $products,
        $defaultTaxRate,
        $currentTaxRate
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        // Config [Catalog Prices] = Including tax & [Enable Cross Border Trade] = No
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'including_tax_and_disable_cross_border_trade']
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
        // Change customer in cart meet Michigan Tax
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        $orderId = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());
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
        while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {
        }
        self::assertEquals(
            $orderId,
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
            "Order Content - Order Id is wrong"
            . "\nExpected: " . $orderId
            . "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
        );
        $actualPriceExcludeTax = $this->webposIndex->getOrderHistoryOrderViewContent()->getPriceOfProduct($products[0]['product']->getName())->getText();
        $actualPriceExcludeTax = substr($actualPriceExcludeTax, 1);
        $actualTaxAmount = $this->webposIndex->getOrderHistoryOrderViewContent()->getTaxAmountOfProduct($products[0]['product']->getName());
        $actualTaxAmount = substr($actualTaxAmount, 1);
        $this->assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade->processAssert(
            $this->webposIndex, $defaultTaxRate, $currentTaxRate, $products[0]['product'], $actualPriceExcludeTax, $actualTaxAmount);
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