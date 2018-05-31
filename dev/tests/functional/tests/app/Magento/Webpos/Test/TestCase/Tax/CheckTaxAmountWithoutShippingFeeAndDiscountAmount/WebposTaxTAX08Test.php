<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/01/2018
 * Time: 09:02
 */

namespace Magento\Webpos\Test\TestCase\Tax\CheckTaxAmountWithoutShippingFeeAndDiscountAmount;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Swatches\Test\Fixture\ConfigurableProduct;
use Magento\Tax\Test\Fixture\TaxRate;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertCreateInvoiceSuccess;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Check tax amount when ordering with shipping fee
 * Testcase TAX08 - Check Tax amount when creating a partial invoice
 *
 * Precondition:
 * 1. Go to backend > Configuration > Sales > Tax:
 * Setting all fields: tick on [Use system value] checkbox
 *
 * Steps
 * 1. Login webpos as a staff
 * 2. Add some  products and select a customer to meet tax condition
 * 3. Place order successfully with:
 * + [Create invoice]: off
 * 4. Go to Order detail > click on [Invoice] button
 * 5. On invoice popup, Edit [qty to invoice] to make a partial invoice
 * 6. Create a partial invoice
 *
 * Acceptance Criteria
 * 5. Tax amount will be updated according to [Qty to invoice] field exactly:
 * - Tax amount of each product  =  (their Subtotal - Discount) x Tax rate
 * - Rowtotal of each product = their Subtotal + Tax - Discount
 * - Tax amount whole cart = SUM(tax amount of each product)
 * - Subtotal whole cart = SUM(Subtotal  of each product)
 * - Grand total = Subtotal whole cart + Shipping + Tax - Discount
 * 6. Create a partial invoice successfully
 *
 * Class WebposTaxTAX08Test
 * @package Magento\Webpos\Test\TestCase\Tax\CheckTaxAmountWithoutShippingFeeAndDiscountAmount
 */
class WebposTaxTAX08Test extends Injectable
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
     * @var AssertCreateInvoiceSuccess
     */
    protected $assertCreateInvoiceSuccess;

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

        //change tax rate
        $taxRate = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);

        return [
            'customer' => $customer,
            'taxRate' => $taxRate->getRate()
        ];
    }

    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
        AssertCreateInvoiceSuccess $assertCreateInvoiceSuccess
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
        $this->assertCreateInvoiceSuccess = $assertCreateInvoiceSuccess;
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
//		// Create products
//		$products = $this->objectManager->getInstance()->create(
//			'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
//			['products' => $products]
//		)->run();
//
//		// Config: use system value for all field in Tax Config
//		$this->objectManager->getInstance()->create(
//			'Magento\Config\Test\TestStep\SetupConfigurationStep',
//			['configData' => $configData]
//		)->run();
//
//		// LoginTest webpos
//		$staff = $this->objectManager->getInstance()->create(
//			'Magento\Webpos\Test\TestStep\LoginWebposStep'
//		)->run();
//
//		// Add product to cart
//		$this->objectManager->getInstance()->create(
//			'Magento\Webpos\Test\TestStep\AddProductToCartStep',
//			['products' => $products]
//		)->run();
//
//		// change customer
//		$this->objectManager->getInstance()->create(
//			'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
//			['customer' => $customer]
//		)->run();
//
//		// Place Order
//		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
//		$this->webposIndex->getMsWebpos()->waitCartLoader();
//		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//
//		$this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
//		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//
//		$this->objectManager->getInstance()->create(
//			'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
//			[
//				'createInvoice' => $createInvoice,
//				'shipped' => $shipped
//			]
//		)->run();
//
//		$this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
//		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//
//		//Assert Place Order Success
//		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
//
//		$orderId = str_replace('#' , '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());
//
//		$this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
//		$this->webposIndex->getMsWebpos()->waitCartLoader();
//
//		$this->webposIndex->getMsWebpos()->clickCMenuButton();
//		$this->webposIndex->getCMenu()->ordersHistory();
//
//		sleep(2);
//		$this->webposIndex->getOrderHistoryOrderList()->waitLoader();
//
//		$this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
//		while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {}
//		self::assertEquals(
//			$orderId,
//			$this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
//			"Order Content - Order Id is wrong"
//			. "\nExpected: " . $orderId
//			. "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
//		);
//
//		$this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
//
//		// Create Invoice
//		$this->objectManager->getInstance()->create(
//			'Magento\Webpos\Test\TestStep\CreateInvoiceInOrderHistoryStep',
//			[
//				'products' => $products
//			]
//		)->run();
//
//		$expectStatus = 'Processing';
//		$this->assertCreateInvoiceSuccess->processAssert($this->webposIndex, $expectStatus);
//
//		return [
//			'products' => $products
//		];
    }
}