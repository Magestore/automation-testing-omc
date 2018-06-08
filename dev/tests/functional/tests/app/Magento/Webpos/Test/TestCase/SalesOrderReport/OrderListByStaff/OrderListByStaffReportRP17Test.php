<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 3:20 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff;

use DateTime;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByStaff;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class OrderListByStaffReportRP17Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff
 * Precondition and setup steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by staff
 * Steps:
 * Filter by staff > Show report
 * Acceptance Criteria:
 * Report table will statistics and show all orders of staffs just selected to filter  within date range
 */
class OrderListByStaffReportRP17Test extends Injectable
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
     * OrderListByStaff page.
     *
     * @var OrderListByStaff $orderListByStaff
     */
    protected $orderListByStaff;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param OrderListByStaff $orderListByStaff
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        OrderListByStaff $orderListByStaff
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->orderListByStaff = $orderListByStaff;
    }

    /**
     * @param array $shifts
     * @param null $fields
     */
    public function test(array $shifts, $fields = null)
    {
        // Preconditions
        $this->orderListByStaff->open();
        $this->orderListByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        //Check exist staff default
        if (isset($shifts['period_type']) && !$this->webPOSAdminReportDashboard->getReportDashboard()->getPeriorTypeOptionByName($shifts['period_type'])->isPresent()) {
            unset($shifts['period_type']);
            $this->webPOSAdminReportDashboard->getReportDashboard()->setFirstOptionPrediodType();
        }
        $this->orderListByStaff->getFilterBlock()->viewsReport($shifts);
        $this->orderListByStaff->getActionsBlock()->showReport();

        //Assert
        $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate();
        $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate();
        $datetime1 = new DateTime($fromDate->getValue());
        $datetime2 = new DateTime($toDate->getValue());
        $interval = $datetime2->diff($datetime1);
        self::assertEquals(
            1,
            $interval->m,
            'In Admin Form Order List By Staff WebPOS Page. The duration time between from date and to date is not correct. It must be one month.'
        );
        $titles = array_map('trim', explode(',', $fields));
        foreach ($titles as $title) {
            self::assertTrue(
                $this->orderListByStaff->getGridBlock()->getTableFieldByTitle($title)->isVisible(),
                'Title ' . $title . ' didn\'t show'
            );
        }

    }
}