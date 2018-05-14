<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 16/01/2018
 * Time: 09:33
 */

namespace Magento\Webpos\Test\TestCase\Tax\TaxClassForShippingTaxableGoodsAndShippingExcludingTax;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\OrderHistory\Refund\AssertRefundSuccess;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposTaxTAX46Test
 * @package Magento\Webpos\Test\TestCase\Tax\TaxClassForShippingTaxableGoodsAndShippingExcludingTax
 */
class WebposTaxTAX46Test extends Injectable
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
	 * @var AssertRefundSuccess
	 */
	protected $assertRefundSuccess;

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
     * @param AssertRefundSuccess $assertRefundSuccess
     */
	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
		AssertRefundSuccess $assertRefundSuccess
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
		$this->assertRefundSuccess = $assertRefundSuccess;
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
		$taxRate = (float) $taxRate/100;
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

		// Place Order
		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

		$this->webposIndex->getCheckoutShippingMethod()->clickShipPanel();
		$this->webposIndex->getCheckoutShippingMethod()->getFlatRateFixed()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $shippingFee = $this->webposIndex->getCheckoutShippingMethod()->getShippingMethodPrice("Flat Rate - Fixed")->getText();
		$shippingFee = (float)substr($shippingFee, 1);

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


		// Create Refund Partial
		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\CreateRefundInOrderHistoryStep',
			[
				'products' => $products
			]
		)->run();

		// Calculate total refunded
		$totalRefunded = 0;
		foreach ($products as $key => $item) {
			$productName = $item['product']->getName();
			$rowTotal = $this->webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName);
			$rowTotal = (float)substr($rowTotal, 1);
			$totalRefunded += ($rowTotal/$item['orderQty'])*$item['refundQty'];
		}

		$totalRefunded += $shippingFee * (1+$taxRate);

		$expectStatus = 'Complete';

		$this->assertRefundSuccess->processAssert($this->webposIndex, $expectStatus, $totalRefunded);

		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\CreateRefundInOrderHistoryStep',
			[
				'products' => $products
			]
		)->run();


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