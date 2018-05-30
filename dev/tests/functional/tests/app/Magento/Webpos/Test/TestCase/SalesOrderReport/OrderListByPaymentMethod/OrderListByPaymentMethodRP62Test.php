<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/30/18
 * Time: 10:56 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethod;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByPayment;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Mtf\TestCase\Injectable;
/**
 * Class OrderListByPaymentMethodRP62Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethod
 *
 */
class OrderListByPaymentMethodRP62Test extends Injectable
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
     * @param Shift $shift
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
     * @param null $order_statuses
     */
    public function test(array $shifts, $order_statuses = null)
    {
        // Preconditions
        $this->orderListByPayment->open();
        $this->orderListByPayment->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $this->orderListByPayment->getFilterBlock()->viewsReport($shifts);
        if ($order_statuses != null) {
            $this->webPOSAdminReportDashboard->getReportDashboard()->setSalesReportOderStatuses($order_statuses);
        }
        $paymentMethod = $this->webPOSAdminReportDashboard->getReportDashboard()->getPaymentMethod()->getText();
        $this->orderListByPayment->getActionsBlock()->showReport();
        $statusOrder = $this->webPOSAdminReportDashboard->getReportDashboard()->getStatusOrder()->getText();
        self::assertEquals(
            $shifts['period_type'],
            $paymentMethod,
            'In Admin Form Order List By Staff WebPOS Page. The period type was not updated. It must be '.$shifts['period_type']
        );
        if ($order_statuses != null) {
            self::assertEquals(
                $order_statuses,
                $statusOrder,
                'In Admin Form Order List By Staff WebPOS Page. Status is not updated. It must be '.$order_statuses
            );
        }
    }
}