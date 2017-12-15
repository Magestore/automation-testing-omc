<?php
/**
 * Copyright © 2017 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\TestCase\Sales;

use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;
use Magento\Mtf\TestCase\Injectable;

class CancelGiftCardOrderTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    /* end tags */

    /**
     * Orders Page.
     *
     * @var OrderIndex
     */
    protected $orderIndex;

    /**
     * Order View Page.
     *
     * @var SalesOrderView
     */
    protected $salesOrderView;

    /**
     * Inject pages.
     *
     * @param OrderIndex $orderIndex
     * @param SalesOrderView $salesOrderView
     * @return void
     */
    public function __inject(OrderIndex $orderIndex, SalesOrderView $salesOrderView)
    {
        $this->orderIndex = $orderIndex;
        $this->salesOrderView = $salesOrderView;
    }

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