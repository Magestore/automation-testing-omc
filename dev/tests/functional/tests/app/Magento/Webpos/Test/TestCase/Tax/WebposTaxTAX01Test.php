<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/3/2018
 * Time: 4:44 PM
 */

namespace Magento\Webpos\Test\TestCase\Tax;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Swatches\Test\Fixture\ConfigurableProduct;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnCartPageAndCheckoutPage;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 *  * Preconditions:
 * 1. Create customer
 * 2. Create products
 *
 * Test Flow:
 * 1. Login Web POS as staff
 * 2. Search product and add to cart
 * 3. Search customer and select customer
 * 4. Click "CHECKOUT" in cart page
 * 5. Choose Payment Method
 * 6. Click Place Order
 * 7. Verify created
 *
 */

/**
 * Class WebposTaxTAX01Test
 * @package Magento\Webpos\Test\TestCase\Tax
 */
class WebposTaxTAX01Test extends Injectable
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
     * @var AssertTaxAmountOnCartPageAndCheckoutPage
     */
    protected $assertTaxAmountOnCartPageAndCheckoutPage;

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
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'UK_address']);
        $customer->persist();

        return ['customer' => $customer];
    }

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertTaxAmountOnCartPageAndCheckoutPage $assertTaxAmountOnCartPageAndCheckoutPage
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertTaxAmountOnCartPageAndCheckoutPage $assertTaxAmountOnCartPageAndCheckoutPage,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertTaxAmountOnCartPageAndCheckoutPage = $assertTaxAmountOnCartPageAndCheckoutPage;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $configData
     * @param bool $createInvoice
     * @param $taxAmount
     * @param bool $shipped
     */
    public function test(
        Customer $customer,
        $products,
        $configData,
        $createInvoice = true,
        $taxAmount,
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

        //Assert Tax Amount on Cart Page
        $this->assertTaxAmountOnCartPageAndCheckoutPage->processAssert($taxAmount, $this->webposIndex);

        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Assert Tax Amount on Checkout Page
        $this->assertTaxAmountOnCartPageAndCheckoutPage->processAssert($taxAmount, $this->webposIndex);
        // End Assert Tax Amount on Checkout Page

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => $createInvoice,
                'shipped' => $shipped
            ]
        )->run();
        // End Place Order

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);

        $orderId = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();

        sleep(2);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();

        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();

    }
}