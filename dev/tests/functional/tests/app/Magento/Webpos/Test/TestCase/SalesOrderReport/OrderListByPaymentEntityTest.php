<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-12 16:07:14
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:26:14
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByPayment;

/**
 * Preconditions:
 * 1. Create customer.
 * 2. Create product.
 * 3. Place order.
 * 4. Refresh statistic.
 *
 * Steps:
 * 1. Open Backend.
 * 2. Go to Reports > Products > Bestsellers.
 * 3. Select time range, report period.
 * 4. Click "Show report".
 * 5. Perform all assertions.
 *
 * @group Reports_(MX)
 * @ZephyrId MAGETWO-28222
 */
class OrderListByPaymentEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * OrderListByPayment page.
     *
     * @var OrderListByPayment $orderListByPayment
     */
    protected $orderListByPayment;

    /**
     * Inject pages.
     *
     * @param OrderListByPayment $orderListByPayment
     * @return void
     */
    public function __inject(OrderListByPayment $orderListByPayment)
    {
        $this->orderListByPayment = $orderListByPayment;
    }

    /**
     * Bestseller Products Report.
     *
     * @param array $shifts
     * @return void
     */
    public function test(array $shifts)
    {
        // Preconditions
        $this->orderListByPayment->open();
        $this->orderListByPayment->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        // Steps
        $this->orderListByPayment->getFilterBlock()->viewsReport($shifts);
        $this->orderListByPayment->getActionsBlock()->showReport();
    }
}
