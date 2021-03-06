<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/31/2018
 * Time: 4:57 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\Invoice;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI\AssertOrdersHistoryTakePaymentNotAvailable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryInvoiceOH114Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\Invoice
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create a pending order with discount 100%
 * Steps:
 * 1. Go to order details page
 * 2. Invoice order just created
 * Acceptance Criteria:
 * 1. No required take payment
 * 2. All items are available to invoice
 */
class WebposOrdersHistoryInvoiceOH114Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertOrdersHistoryTakePaymentNotAvailable $assertOrdersHistoryTakePaymentNotAvailable
     */
    protected $assertOrdersHistoryTakePaymentNotAvailable;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertOrdersHistoryTakePaymentNotAvailable $assertOrdersHistoryTakePaymentNotAvailable
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertOrdersHistoryTakePaymentNotAvailable $assertOrdersHistoryTakePaymentNotAvailable
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertOrdersHistoryTakePaymentNotAvailable = $assertOrdersHistoryTakePaymentNotAvailable;
    }

    /**
     * @param $products
     * @param bool $addDiscount
     * @param null $discountAmount
     * @return array
     */
    public function test(
        $products,
        $addDiscount = false,
        $discountAmount = null
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

        // Add Discount
        if ($addDiscount) {
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
            sleep(1);
            self::assertTrue(
                $this->webposIndex->getCheckoutDiscount()->isVisible(),
                'CategoryRepository - TaxClass page - Delete TaxClass - Add discount popup is not shown'
            );
            $this->webposIndex->getCheckoutDiscount()->setDiscountPercent($discountAmount);
            $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        }

        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        for ($i = 0; $i < 3; $i++) {
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        }

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => false,
                'shipped' => false
            ]
        )->run();
        sleep(1);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();

        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);

        // Assert Take payment
        $this->assertOrdersHistoryTakePaymentNotAvailable->processAssert($this->webposIndex);

        $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
        $this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();

        return [
            'products' => $products
        ];
    }

}