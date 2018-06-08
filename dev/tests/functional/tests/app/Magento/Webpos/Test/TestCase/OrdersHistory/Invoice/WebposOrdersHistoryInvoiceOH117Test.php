<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/2/2018
 * Time: 1:55 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\Invoice;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI\AssertWebposOrdersHistoryInvoice;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryInvoiceOH117Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\Invoice
 * Precondition and setup steps:
 * 1. Go to backend
 * 2. Create an order with amount payment =0
 * Steps:
 * 1. Login webpos as a staff
 * 2. Go to order details page
 * 3. Click on Invoice button
 * Acceptance Criteria:
 * Show message: "Warning: You must take payment on this order before creating invoice"
 */
class WebposOrdersHistoryInvoiceOH117Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposOrdersHistoryInvoice $assertWebposOrdersHistoryInvoice
     */
    protected $assertWebposOrdersHistoryInvoice;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposOrdersHistoryInvoice $assertWebposOrdersHistoryInvoice
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposOrdersHistoryInvoice $assertWebposOrdersHistoryInvoice
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposOrdersHistoryInvoice = $assertWebposOrdersHistoryInvoice;
    }

    /**
     * @param $products
     * @return array
     */
    public function test(
        $products
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
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

        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue(0);
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Order history
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMainContent()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);

        // Click Button Invoice
        $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();

        return [
            'products' => $products
        ];
    }
}