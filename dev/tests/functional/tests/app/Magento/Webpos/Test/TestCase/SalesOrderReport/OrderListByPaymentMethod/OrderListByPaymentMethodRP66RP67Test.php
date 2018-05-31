<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/30/18
 * Time: 6:14 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethod;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByPayment;
use Magento\Mtf\TestCase\Injectable;
/**
 * Class OrderListByPaymentMethodRP66RP67Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethod
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

    public function test($type)
    {
        // Preconditions
        $this->orderListByPayment->open();
        $this->orderListByPayment->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $this->webPOSAdminReportDashboard->getReportDashboard()->clickTypeExport($type)->click();
        $this->webPOSAdminReportDashboard->getReportDashboard()->getButtonExport()->click();
    }
}