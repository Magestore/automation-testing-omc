<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/30/18
 * Time: 6:02 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByPaymentMethod;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByPayment;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class OrderListByPaymentMethodRP63Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethod
 * Precondition and setup steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by payment method
 *
 * Steps
 * Filter by date range > Show report
 *
 * Acceptance Criteria
 * Report table will statistical within date range
 */
class OrderListByPaymentMethodRP63Test extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * WebPOSAdminReportDashboard page.
     *
     * @var WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     */
    protected $webPOSAdminReportDashboard;

    /**
     * OrderListByPayment page.
     *
     * @var OrderListByPayment $orderListByPayment
     */
    protected $orderListByPayment;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param OrderListByPayment $orderListByPayment
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        OrderListByPayment $orderListByPayment
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->orderListByPayment = $orderListByPayment;
    }

    /**
     * @param array $shifts
     */
    public function test(array $shifts)
    {
        // Preconditions
        $this->orderListByPayment->open();
        $this->orderListByPayment->getMessagesBlock()->clickLinkInMessage('notice', 'here');
        // Steps
        $fromDateBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        $this->orderListByPayment->getFilterBlock()->viewsReport($shifts);
        $this->orderListByPayment->getActionsBlock()->showReport();
        $fromDateAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        self::assertNotEquals(
            $fromDateBefore,
            $fromDateAfter,
            'In Admin. Sales Order Report. Form Order List By Payment. Time of input from date and to date is not changed.'
        );
    }
}