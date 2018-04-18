<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 12/01/2018
 * Time: 09:05
 */
namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;
class AssertOrderDetailCommentIsCorrectBackAnd extends AbstractConstraint
{
    public function processAssert(OrderIndex $orderIndex, SalesOrderView $salesOrderView, $comment, $orderId)
    {
        $orderIndex->open();
        $orderIndex->getSalesOrderGrid()->searchAndOpen(['id' => $orderId]);
        sleep(1);
        $commentActual = $salesOrderView->getOrderHistoryBlock()->getComment();
        \PHPUnit_Framework_Assert::assertEquals(
            $comment,
            $commentActual,
            'Order Detail - comment is wrong'
            . "\nExpected: " . $comment
            . "\nActual: " . $commentActual
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
