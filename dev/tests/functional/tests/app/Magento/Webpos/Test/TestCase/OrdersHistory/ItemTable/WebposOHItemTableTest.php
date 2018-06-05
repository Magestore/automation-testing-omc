<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/01/2018
 * Time: 10:59
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\ItemTable;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOHItemTableTest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\ItemTable
 * Precondition and setup steps:
 * OH16
 * In backend setting:
 * Configuration > Sales > Tax > Calculation settings:
 * [Apply Customer Tax] = Before discount
 * On webpos:
 * 1. Login Webpos as a staff
 * 2. Add a product and select a customer to meet tax condition
 * 3. Click to name of that product > Custom price > input amount: ""50""
 * 4. Click to Add discount for whole cart > input: fixed ""10""
 * 3. Place order successfully with complete status
 * Steps:
 * 1. Go to [Orders history] menu
 * Acceptance Criteria:
 * On order detail, show item table including:
 * - Product: show product name and SKU
 * - Original Price: show original of the product
 * - Price: ""50""
 * - Qty:
 * Ordered:1
 * Invoiced:1
 * Shipped:1
 * - Subtotal = Price x qty
 * - Tax amount: show tax of the order
 * - Discount amount: show ""10""
 * - Row total = Subtotal + tax - discount
 *
 * OH17:
 * Precondition and setup steps:
 * In backend setting:
 * Configuration > Sales > Tax > Calculation settings:
 * [Apply Customer Tax] = After discount
 * On webpos:
 * 1. Login Webpos as a staff
 * 2. Add a product with qty = 2 and select a customer to meet tax condition
 * 3. Click to name of that product > Custom price > input amount: ""50""
 * 4. Click to Add discount for whole cart > input: fixed ""10""
 * 3. Place order successfully with
 * - [Mark a shipped]: off
 * - [Create invoice]: on
 * Steps:
 * 1. Go to [Orders history] menu
 * Acceptance Criteria:
 * On order detail, show item table including:
 * - Product: show product name and SKU
 * - Original Price: show original of the product
 * - Price: ""50""
 * - Qty:
 * Ordered: 2
 * Invoiced: 2
 * - Subtotal = Price x qty
 * - Tax amount: show tax of the order
 * - Discount amount: show ""10""
 * - Row total = Subtotal + tax - discount
 *
 * OH18
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Add 2 different  products and select a customer to meet tax condition
 * 3. Click to Add discount for whole cart > input: fixed ""10""
 * 4. Place order successfully with
 * - [Mark a shipped]: off
 * - [Create invoice]: on
 * Steps:
 * 1. Go to [Orders history] menu
 * Acceptance Criteria:
 * On order detail, show item table including 2 rows with:
 * - Product: show product names and SKUs
 * - Original Price: show original of the  products
 * - Price: show price of the  products
 * - Qty:
 * Ordered: 1
 * Invoiced: 1
 * - Subtotal = Price x qty
 * - Tax amount: show tax of each product
 * - Discount amount: show discount of each product
 * Discount amount = Price/ Sum of Price x 10
 * - Row total = Subtotal + tax - discount
 */
class WebposOHItemTableTest extends Injectable
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
     */
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

    /**
     * @param Customer $customer
     * @param $products
     * @param $configData
     * @param $discountAmount
     * @param bool $createInvoice
     * @param bool $shipped
     * @return array
     */
    public function test(
        Customer $customer,
        $products,
        $configData,
        $discountAmount,
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

        // Custom Price
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\EditCustomPriceOfProductOnCartStep',
            ['products' => $products]
        )->run();

        // Add Discount
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddDiscountWholeCartStep',
            [
                'percent' => $discountAmount,
                'type' => '$'
            ]
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
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        if (!$this->webposIndex->getCheckoutPaymentMethod()->getIconRemove()->isVisible()) {
            $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        }

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);

        $orderId = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        //Open the First Order
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {
        }
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

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();
    }
}