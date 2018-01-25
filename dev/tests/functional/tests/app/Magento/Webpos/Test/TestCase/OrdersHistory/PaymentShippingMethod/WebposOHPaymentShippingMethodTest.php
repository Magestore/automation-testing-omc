<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/01/2018
 * Time: 09:45
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\PaymentShippingMethod;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOHPaymentShippingMethodTest extends Injectable
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
	 * Prepare data.
	 *
	 * @param FixtureFactory $fixtureFactory
	 * @return array
	 */
	public function __prepare(FixtureFactory $fixtureFactory)
	{
		// Config
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'default_tax_configuration_use_system_value']
		)->run();
	}

	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
	}

	public function test(
		$products = null,
		$addCustomSale = false,
		$customProduct = null,
		$addDiscount = false,
		$discountAmount = '',
		$addShipping = false,
		$addPayment = true
	)
	{

		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		if ($addCustomSale) {
			$this->objectManager->getInstance()->create(
				'Magento\Webpos\Test\TestStep\AddCustomSaleStep',
				['customProduct' => $customProduct]
			)->run();
		} else {
			// Create products
			$products = $this->objectManager->getInstance()->create(
				'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
				['products' => $products]
			)->run();

			// Add product to cart
			$this->objectManager->getInstance()->create(
				'Magento\Webpos\Test\TestStep\AddProductToCartStep',
				['products' => $products]
			)->run();
		}

		if ($addDiscount) {
			$this->objectManager->getInstance()->create(
				'Magento\Webpos\Test\TestStep\AddDiscountWholeCartStep',
				['percent' => $discountAmount]
			)->run();
		}

		// Place Order
		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		if ($addShipping) {
			if (!$this->webposIndex->getCheckoutShippingMethod()->getFlatRateFixed()->isVisible()) {
				$this->webposIndex->getCheckoutShippingMethod()->clickShipPanel();
			}
			$this->webposIndex->getCheckoutShippingMethod()->getFlatRateFixed()->click();
			$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
		}

		$paymentAmount = 0;
		if ($addPayment) {
			$this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
			$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
			$paymentAmount = $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->getValue();
			$paymentAmount = (float) substr($paymentAmount, 1);
		}

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

		return [
			'products' => $products,
			'paymentAmount' => $paymentAmount
		];
	}

	public function tearDown()
	{

	}
}