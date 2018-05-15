<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/01/2018
 * Time: 08:17
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionCancel;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\OrderHistory\Shipment\AssertShipmentSuccess;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposOHMassActionCancelTest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionCancel
 */
class WebposOHMassActionCancelTest extends Injectable
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
	 * @var AssertShipmentSuccess
	 */
	protected $assertShipmentSuccess;

	public function __inject (
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
		AssertShipmentSuccess $assertShipmentSuccess
	) {
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
		$this->assertShipmentSuccess = $assertShipmentSuccess;
	}

	public function test (
		$createOrderInBackend = false,
		OrderInjectable $order = null,
		$products = null,
		$addCustomSale = false,
		$customProduct = null,
		$createInvoice = true,
		$shipped = false,
		$createShipment = false,
		$comment = null,
		$action = 'save',
		$confirmAction = 'ok'
	) {
		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		if ($createOrderInBackend) {
			$order->persist();
			$orderId = $order->getId();
		} else {
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

			// Place Order
			$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
			for ($i=0; $i<2; $i++) {
                $this->webposIndex->getMsWebpos()->waitCartLoader();
                $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
            }

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
		}

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        //select the first order
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
		while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {}
		self::assertEquals(
			$orderId,
			$this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
			"Order Content - Order Id is wrong"
			. "\nExpected: " . $orderId
			. "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
		);

		// Create Shipment
		if ($createShipment) {
			$this->objectManager->getInstance()->create(
				'Magento\Webpos\Test\TestStep\CreateShipmentInOrderHistoryStep',
				[
					'products' => $products
				]
			)->run();
			$this->assertShipmentSuccess->processAssert($this->webposIndex);
		}

		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\CancelOrderStep',
			[
				'comment' => $comment,
				'action' => $action,
				'confirmAction' => $confirmAction
			]
		)->run();

		return [
			'products' => $products,
			'orderId' => $orderId
		];
	}
}