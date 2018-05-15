<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 11/01/2018
 * Time: 16:24
 */
namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertOrderDetailCommentIsCorrect extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $comment, $orderId)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->ordersHistory();
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getMsWebpos()->waitOrdersHistoryVisible();

        $webposIndex->getOrderHistoryOrderList()->search($orderId);
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();

        \PHPUnit_Framework_Assert::assertEquals(
            $comment,
            $webposIndex->getOrderHistoryOrderViewContent()->getValueComment(),
            'Order Detail - comment is wrong'
            . "\nExpected: " . $comment
            . "\nActual: " . $webposIndex->getOrderHistoryOrderViewContent()->getValueComment()
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order Detail - Comment is correct";
    }
}