<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\Constraint\Sales;

use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;

/**
 * Assert that order is present in Orders grid.
 */
class AssertOrderInOrdersGrid extends \Magento\Sales\Test\Constraint\AssertOrderInOrdersGrid
{
    /**
     * Process assert.
     *
     * @param OrderInjectable $order
     * @param OrderIndex $orderIndex
     * @param string $status
     * @param string $orderId [optional]
     * @return void
     */
    public function assert(OrderInjectable $order, OrderIndex $orderIndex, $status, $orderId = '')
    {
        $filter = [
            'id' => $order->hasData('increment_id') ? $order->getIncrementId() : $orderId,
            'status' => $status
        ];
        $errorMessage = implode(', ', $filter);
        \PHPUnit_Framework_Assert::assertTrue(
            $orderIndex->getSalesOrderGrid()->isRowVisible(array_filter($filter)),
            'Order with following data \'' . $errorMessage . '\' is absent in Orders grid.'
        );
    }

}
