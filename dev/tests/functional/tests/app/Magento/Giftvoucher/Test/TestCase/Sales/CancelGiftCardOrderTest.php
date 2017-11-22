<?php
/**
 * Copyright © 2017 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\Sales;

use Magento\Sales\Test\TestCase\CancelCreatedOrderTest;
use Magento\Sales\Test\Fixture\OrderInjectable;

class CancelGiftCardOrderTest extends CancelCreatedOrderTest
{
    /**
     * Cancel created order.
     *
     * @param OrderInjectable $order
     * @return array
     */
    public function test(OrderInjectable $order)
    {
        // Preconditions
        $order->persist();

        // Steps
        $this->orderIndex->open();
        $this->orderIndex->getSalesOrderGrid()->searchAndOpen(['id' => $order->getIncrementId()]);
        $this->salesOrderView->getPageActions()->cancel();

        return [
            'customer' => $order->getDataFieldConfig('customer_id')['source']->getCustomer(),
        ];
    }    
}