<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 17/01/2018
 * Time: 10:45
 */

namespace Magento\Webpos\Test\TestCase\Tax;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnOrderHistoryInvoice;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposTaxTAX95Test extends Injectable
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
	 * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
	 */
	protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

	/**
	 * @var AssertTaxAmountOnOrderHistoryInvoice
	 */
	protected $assertTaxAmountOnOrderHistoryInvoice;

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

		return [
			'customer' => $customer,
			'taxRate' => $taxRate->getRate()
		];
	}

	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
		AssertTaxAmountOnOrderHistoryInvoice $assertTaxAmountOnOrderHistoryInvoice
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
		$this->assertTaxAmountOnOrderHistoryInvoice = $assertTaxAmountOnOrderHistoryInvoice;
	}

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

		// Login webpos
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

		// Edit Custom Price Of Product
		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\EditCustomPriceOfProductOnCartStep',
			['products' => $products]
		)->run();

		// Assert SubTotal updated
		$subTotal = 0;
		foreach ($products as $item) {
			$subTotal += $item['customPrice'] * $item['orderQty'];
		}
		$subTotalOnPage = $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Subtotal')->getText();
		$subTotalOnPage = (float)substr($subTotalOnPage, 1);

		self::assertEquals(
			$subTotal,
			$subTotalOnPage,
			'Cart Page - Subtotal was not updated after edit custom price'
			. "\nExpected: " . $subTotal
			. "\nActual: " . $subTotalOnPage
		);

		// Place Order
		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

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

		// Assert Subtotal on Order Detail Page is correct
		$subTotalOnPage = $this->webposIndex->getOrderHistoryOrderViewFooter()->getSubtotal();
		$subTotalOnPage = (float)substr($subTotalOnPage, 1);

		self::assertEquals(
			$subTotal,
			$subTotalOnPage,
			'Order History - Subtotal was not updated with edit custom price'
			. "\nExpected: " . $subTotal
			. "\nActual: " . $subTotalOnPage
		);

		$this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
		$this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();

		// Assert Tax amount on Invoice popup
		$this->assertTaxAmountOnOrderHistoryInvoice->processAssert($taxRate, $products, $this->webposIndex);

		$this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
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