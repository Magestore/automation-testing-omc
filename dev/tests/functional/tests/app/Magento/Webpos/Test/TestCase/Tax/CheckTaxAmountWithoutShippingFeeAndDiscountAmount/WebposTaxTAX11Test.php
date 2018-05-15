<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 17/01/2018
 * Time: 10:02
 */

namespace Magento\Webpos\Test\TestCase\Tax\CheckTaxAmountWithoutShippingFeeAndDiscountAmount;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\OrderHistory\Refund\AssertRefundPriceOfProductWithTaxIsCorrect;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposTaxTAX11Test
 * @package Magento\Webpos\Test\TestCase\Tax\CheckTaxAmountWithoutShippingFeeAndDiscountAmount
 */
class WebposTaxTAX11Test extends Injectable
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
	 * @var AssertRefundPriceOfProductWithTaxIsCorrect
	 */
	protected $assertRefundPriceOfProductWithTaxIsCorrect;

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

		return [
			'customer' => $customer,
			'taxRate' => $taxRate->getRate()
		];
	}

	/**
	 * @param WebposIndex $webposIndex
	 * @param FixtureFactory $fixtureFactory
	 * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
	 * @param AssertRefundPriceOfProductWithTaxIsCorrect $assertRefundPriceOfProductWithTaxIsCorrect
	 */
	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
		AssertRefundPriceOfProductWithTaxIsCorrect $assertRefundPriceOfProductWithTaxIsCorrect
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
		$this->assertRefundPriceOfProductWithTaxIsCorrect = $assertRefundPriceOfProductWithTaxIsCorrect;
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
        $this->webposIndex->getCheckoutCartFooter()->waitForButtonCheckout();
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
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
		$this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();

		$this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
		while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {}
		self::assertEquals(
			$orderId,
			$this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
			"Order Content - Order Id is wrong"
			. "\nExpected: " . $orderId
			. "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
		);

		$refundText = 'Refund';
		if (!$this->webposIndex->getOrderHistoryContainer()->getActionsBox()->isVisible()) {
			$this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
		}
		$this->webposIndex->getOrderHistoryOrderViewHeader()->getAction($refundText)->click();
		$this->webposIndex->getOrderHistoryContainer()->waitForRefundPopupIsVisible();

		//Assert Price of product
		$this->assertRefundPriceOfProductWithTaxIsCorrect->processAssert($this->webposIndex, $products, $taxRate);
        foreach ($products as $item) {
            if (isset($item['refundQty'])) {
                $this->webposIndex->getOrderHistoryRefund()->getItemQtyToRefundInput($item['product']->getName())->setValue($item['refundQty']);
            }
        }
		$this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
		sleep(2);
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