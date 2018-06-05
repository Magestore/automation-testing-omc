<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/30/18
 * Time: 10:33 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByPaymentMethod;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByPayment;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class OrderListByPaymentMethodRP61Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByPaymentMethod
 * Steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by payment method
 * Acceptance Criteria:
 * 1. Redirect to Order list by payment method page
 * 2. Allow filter report by payment method, date range and order status
 * 3. Report table show  all order created by each staff within one month with information as: Order id, Sale total,  purchased on, Status
 * 4. Data will be group by each payment method
 */
class OrderListByPaymentMethodRP61Test extends Injectable
{
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
     * @param $pageTitle
     * @param $columns
     */
    public function test($pageTitle, $columns)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getPaymentReport()->getPOSSalesByPaymentDailyIcon()->click();
        sleep(2);
        self::assertEquals(
            $pageTitle,
            $this->orderListByPayment->getTitleBlock()->getTitle(),
            'In Admin Form Sales by payment method WebPOS Page. The page title is not correct. It must be ' . $pageTitle . 'The actual ' . $this->orderListByPayment->getTitleBlock()->getTitle()
        );
        $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate();
        $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate();
        $oderStatus = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportShowOrderStatuses();
        self::assertTrue(
            $fromDate->isVisible(),
            'In Admin Form Sales by payment method WebPOS Page. The Input From Date is not visible.'
        );
        self::assertTrue(
            $toDate->isVisible(),
            'In Admin Form Sales by payment method WebPOS Page. The Input To Date is not visible.'
        );
        self::assertTrue(
            $oderStatus->isVisible(),
            'In Admin Form Sales by payment method WebPOS Page. The Selection Order Status is not visible.'
        );
        self::assertEquals(
            1,
            $toDate->getValue() - $fromDate->getValue(),
            'In Admin Form Sales by payment method WebPOS Page. The duration time between from date and to date is not correct. It must be one month.'
        );
        foreach ($columns as $column) {
            self::assertTrue(
                $this->webPOSAdminReportDashboard->getReportDashboard()->columnIsVisible($column),
                'In Admin Form Sales by payment method WebPOS Page. In the Grid Sales by payment method The Column is not visible.'
            );
        }
    }
}