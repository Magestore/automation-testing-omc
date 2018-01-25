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

class WebposOHPaymentShippingMethodNoMethodTest extends Injectable
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
		$discountAmount = ''
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

		if ($addCustomSale) {
			$this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
			$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
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
			'products' => $products
		];
	}
}