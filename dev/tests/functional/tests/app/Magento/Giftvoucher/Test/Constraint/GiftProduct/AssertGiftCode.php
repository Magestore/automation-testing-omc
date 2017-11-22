<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftProduct;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;

class AssertGiftCode extends AbstractConstraint
{
    /**
     * Assert that Order Grand Total is correct on order page in backend
     *
     * @param SalesOrderView $salesOrderView
     * @param string $orderId
     * @param OrderIndex $salesOrder
     * @param array $prices
     * @return void
     */
    public function processAssert(
        SalesOrderView $salesOrderView,
        OrderIndex $salesOrder,
        $orderId,
        array $prices
    ) {
        $salesOrder->open();
        $salesOrder->getSalesOrderGrid()->searchAndOpen(['id' => $orderId]);

        \PHPUnit_Framework_Assert::assertEquals(
            $prices['grandTotal'],
            $salesOrderView->getOrderTotalsBlock()->getGrandTotal(),
            'Grand Total price does not equal to price from data set.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Grand Total price equals to price from data set.';
    }
}
