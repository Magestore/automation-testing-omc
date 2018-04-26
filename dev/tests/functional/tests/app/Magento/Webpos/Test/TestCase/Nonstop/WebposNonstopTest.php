<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/01/2018
 * Time: 08:59
 */

namespace Magento\Webpos\Test\TestCase\Nonstop;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\OrderHistory\AssertOrderStatus;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertInvoiceSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\Payment\AssertPaymentSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\Refund\AssertRefundSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\Shipment\AssertShipmentSuccess;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposNonstopTest extends Injectable
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
	 * @var AssertPaymentSuccess
	 */
	protected $assertPaymentSuccess;

	/**
	 * @var AssertInvoiceSuccess
	 */
	protected $assertInvoiceSuccess;

	/**
	 * @var AssertShipmentSuccess
	 */
	protected $assertShipmentSuccess;

	/**
	 * @var AssertRefundSuccess
	 */
	protected $assertRefundSuccess;

	/**
	 * @var AssertOrderStatus
	 */
	protected $assertOrderStatus;

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
			['configData' => 'default_payment_method_all_payment']
		)->run();

		return [
			'customer' => $customer,
			'taxRate' => $taxRate->getRate()
		];
	}

	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertPaymentSuccess $assertPaymentSuccess,
		AssertInvoiceSuccess $assertInvoiceSuccess,
		AssertShipmentSuccess $assertShipmentSuccess,
		AssertRefundSuccess $assertRefundSuccess,
		AssertOrderStatus $assertOrderStatus,
		AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertPaymentSuccess = $assertPaymentSuccess;
		$this->assertInvoiceSuccess = $assertInvoiceSuccess;
		$this->assertShipmentSuccess = $assertShipmentSuccess;
		$this->assertRefundSuccess = $assertRefundSuccess;
		$this->assertOrderStatus = $assertOrderStatus;
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
	}

	public function test(
		Customer $customer,
		$taxRate,
		$dataProducts,
		$createInvoice = true,
		$shipped = false
	)
	{
		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();
		$count = 0;
		while(1) {
			// Create products
			$products = $this->objectManager->getInstance()->create(
				'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
				['products' => $dataProducts]
			)->run();
			for ($i = 0; $i < 4999; $i++) {
				$count++;
//				\Zend_Debug::dump(' '.$count.' |');
				fwrite(STDOUT, $count.' | ');
				// Open checkout page
				$this->webposIndex->getMsWebpos()->clickCMenuButton();
				$this->webposIndex->getCMenu()->checkout();
				$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
				$this->webposIndex->getCheckoutCartFooter()->waitButtonHoldVisible();
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

				$this->webposIndex->getCheckoutPaymentMethod()->getPaymentMethodByLabel('Web POS - Cash On Delivery')->click();
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
                sleep(3);
				$this->webposIndex->getMsWebpos()->clickCMenuButton();
				$this->webposIndex->getCMenu()->ordersHistory();

				$this->webposIndex->getOrderHistoryOrderList()->waitLoader();
				sleep(2);
				$this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
				while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {}
				self::assertEquals(
					$orderId,
					$this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
					"Order Content - Order Id is wrong"
					. "\nExpected: " . $orderId
					. "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
				);
                sleep(5);
				$this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
                $this->webposIndex->getOrderHistoryPayment()->waitForPaymendMethodVisible('Web POS - Cash In');
				$this->webposIndex->getOrderHistoryPayment()->getPaymentMethod('Web POS - Cash In')->click();
				$this->webposIndex->getOrderHistoryPayment()->getSubmitButton()->click();
				$this->webposIndex->getMsWebpos()->waitForModalPopup();
				$this->webposIndex->getModal()->getOkButton()->click();
				//Assert Take payment success
//				$this->assertPaymentSuccess->processAssert($this->webposIndex);

				// Invoice
				$this->objectManager->getInstance()->create(
					'Magento\Webpos\Test\TestStep\CreateInvoiceInOrderHistoryStep',
					['products' => $products]
				)->run();

				// Assert Invoice Success
//				$this->assertInvoiceSuccess->processAssert($this->webposIndex);
				// Assert Order Status
				$this->webposIndex->getOrderHistoryOrderViewHeader()->waitForProcessingStatusVisisble();
				$this->assertOrderStatus->processAssert($this->webposIndex, 'Processing');

				// Shipment
				if (!$this->webposIndex->getOrderHistoryContainer()->getActionsBox()->isVisible()) {
					$this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
				}
				$this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Ship')->click();
				$this->webposIndex->getOrderHistoryContainer()->waitForShipmentPopupIsVisible();
				$this->webposIndex->getOrderHistoryShipment()->getSubmitButton()->click();
				$this->webposIndex->getMsWebpos()->waitForModalPopup();
				$this->webposIndex->getModal()->getOkButton()->click();

				// Assert Shipment Success
//				$this->assertShipmentSuccess->processAssert($this->webposIndex);
				// Assert Order Status
				$this->webposIndex->getOrderHistoryOrderViewHeader()->waitForCompleteStatusVisisble();
				$this->assertOrderStatus->processAssert($this->webposIndex, 'Complete');

				// Create Refund Partial
				$this->objectManager->getInstance()->create(
					'Magento\Webpos\Test\TestStep\CreateRefundInOrderHistoryStep',
					[
						'products' => $products
					]
				)->run();

				// Calculate total refunded
				$shippingFee = $this->webposIndex->getOrderHistoryOrderViewFooter()->getShipping();
				$shippingFee = (float)substr($shippingFee, 1);
				$totalRefunded = 0;
				foreach ($products as $key => $item) {
					$productName = $item['product']->getName();
					$rowTotal = $this->webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName);
					$rowTotal = (float)substr($rowTotal, 1);
					$totalRefunded += ($rowTotal/$item['orderQty'])*$item['refundQty'];
				}
				$totalRefunded += $shippingFee;

				$expectStatus = 'Complete';

//				$this->assertRefundSuccess->processAssert($this->webposIndex, $expectStatus, $totalRefunded);

				// Refund Extant Items
				$tempProducts = $products;
				foreach ($tempProducts as $key => $item) {
					unset($tempProducts[$key]['refundQty']);
				}
                sleep(2);
				// Refund
//				$this->objectManager->getInstance()->create(
//					'Magento\Webpos\Test\TestStep\CreateRefundInOrderHistoryStep',
//					['products' => $tempProducts]
//				)->run();

				$this->webposIndex->getOrderHistoryOrderViewHeader()->waitForClosedStatusVisisble();
				$this->assertOrderStatus->processAssert($this->webposIndex, 'Complete');
			}
		}
	}
}