<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 19/01/2018
 * Time: 10:03
 */

namespace Magento\Webpos\Test\TestCase\Tax\ApplyTaxOnCustomeOriginalPriceOnly;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\OrderHistory\Refund\AssertRefundPriceOfProductWithTaxIsCorrect;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposTaxTAX96Test
 * @package Magento\Webpos\Test\TestCase\Tax
 */
class WebposTaxTAX96Test extends Injectable
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

		// Edit Custom Price Of Product
		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\EditCustomPriceOfProductOnCartStep',
			['products' => $products]
		)->run();

        sleep(5);

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
			'Checkout Page - Subtotal was not updated after edit custom price'
			. "\nExpected: " . $subTotal
			. "\nActual: " . $subTotalOnPage
		);

		// Place Order
		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        sleep(3);

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

		$refundText = 'Refund';
		if (!$this->webposIndex->getOrderHistoryContainer()->getActionsBox()->isVisible()) {
			$this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
		}
		$this->webposIndex->getOrderHistoryOrderViewHeader()->getAction($refundText)->click();
		$this->webposIndex->getOrderHistoryContainer()->waitForRefundPopupIsVisible();

        foreach ($products as $item) {
            if (isset($item['refundQty'])) {
                $this->webposIndex->getOrderHistoryRefund()->getItemQtyToRefundInput($item['product']->getName())->setValue($item['refundQty']);
            }
        }

		//Assert Price of product
		$useCustomPrice = true;
		$this->assertRefundPriceOfProductWithTaxIsCorrect->processAssert($this->webposIndex, $products, $taxRate, $useCustomPrice);

		$this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
		sleep(2);
		$this->webposIndex->getModal()->getOkButton()->click();


		return [
			'products' => $products
		];
	}

	/**
	 *
	 */
	public function tearDown()
	{
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'default_tax_configuration_use_system_value']
		)->run();
	}
}