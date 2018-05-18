<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 15/01/2018
 * Time: 10:01
 */

namespace Magento\Webpos\Test\TestCase\Tax\TaxClassForShippingTaxableGoodsAndShippingExcludingTax;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposTaxTAX41Test
 * @package Magento\Webpos\Test\TestCase\Tax\TaxClassForShippingTaxableGoodsAndShippingExcludingTax
 */
class WebposTaxTAX41Test extends Injectable
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
	 * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
	 */
	protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

	/**
	 * @var AssertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax $assertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax
	 */
	protected $assertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax;

	/**
	 * Prepare data.
	 *
	 * @param FixtureFactory $fixtureFactory
	 * @return array
	 */
	public function __prepare(FixtureFactory $fixtureFactory)
	{
		$customer = $fixtureFactory->createByCode('customer', ['dataset' => 'johndoe_MI_unique_first_name']);
		$customer->persist();
		$taxRate = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-MI-Rate_1']);
		$this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);
		// Config: use system value for all field in Tax Config
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'default_tax_configuration_use_system_value']
		)->run();
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'all_allow_shipping_for_POS']
		)->run();
		return [
			'customer' => $customer,
			'taxRate' => $taxRate->getRate()
		];
	}

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     * @param AssertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax $assertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax
     */
	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
		AssertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax $assertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
		$this->assertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax = $assertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax;
	}

    /**
     * @param Customer $customer
     * @param $taxRate
     * @param $products
     * @param $configData
     * @param bool $createInvoice
     * @param bool $shipped
     * @return array
     */
	public function test(
		Customer $customer,
		$taxRate,
		$products,
		$configData,
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
		// change customer
		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
			['customer' => $customer]
		)->run();
		// Place Order
		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
		$this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
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
		//Assert Place Order Success
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
		$orderId = str_replace('#' , '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());

		$this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
		$this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
		while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {}
		self::assertEquals(
			$orderId,
			$this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
			"Order Content - Order Id is wrong"
			. "\nExpected: " . $orderId
			. "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
		);
		$this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
		$this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
        sleep(1);
		// Assert Tax amount on Invoice popup
		$this->assertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax->processAssert($taxRate, $products, $this->webposIndex);

		$this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();
		return [
			'products' => $products
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