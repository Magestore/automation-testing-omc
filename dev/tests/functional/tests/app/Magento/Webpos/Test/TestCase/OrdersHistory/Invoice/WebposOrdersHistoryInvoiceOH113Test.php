<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/1/2018
 * Time: 2:06 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\Invoice;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI\AssertWebposOrdersHistoryInvoice;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryInvoiceOH113Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\Invoice
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create a pending order with some  products
 * 3. Paid a partial when place order
 * Steps:
 * 1. Go to order details page
 * 2. Invoice order just created
 * Acceptance Criteria:
 * Just allow invoice items that have Row total less than total paid
 */
class WebposOrdersHistoryInvoiceOH113Test extends Injectable
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
        $paymentPrice = (float)substr($this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->getValue(), 1);
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue($paymentPrice / 2);
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => false,
                'shipped' => false
            ]
        )->run();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        // Order history
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        $totalPaid = (float)substr($this->webposIndex->getOrderHistoryOrderViewFooter()->getTotalPaid(), 1);
        // Click Button Invoice
        sleep(1);
        $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
        $this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
        sleep(2);

        return [
            'products' => $products,
            'totalPaid' => $totalPaid
        ];
    }
}