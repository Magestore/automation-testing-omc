<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/30/18
 * Time: 6:14 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethod;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByPayment;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class OrderListByPaymentMethodRP66RP67Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethod
 * RP66 & RP67
 * Precondition and setup steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by payment method
 *
 * RP66
 * Steps
 * Export report to CSV file
 * Acceptance Criteria
 * CSV file will be downloaded automatically and saved on the computer
 *
 * RP67
 * Steps
 * Export report to Excel XML file
 * Acceptance Criteria
 * Excel XML file will be downloaded automatically and saved on the computer
 */
class OrderListByPaymentMethodRP66RP67Test extends Injectable
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
     * @param $type
     */
    public function test($type)
    {
        // Preconditions
        $this->orderListByPayment->open();
        $this->orderListByPayment->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $this->webPOSAdminReportDashboard->getReportDashboard()->clickTypeExport($type)->click();
        $this->webPOSAdminReportDashboard->getReportDashboard()->getButtonExport()->click();
    }
}