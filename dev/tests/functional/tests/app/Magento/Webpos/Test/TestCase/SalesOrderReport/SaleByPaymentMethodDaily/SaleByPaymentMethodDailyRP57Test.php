<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/30/18
 * Time: 10:04 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodDaily;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\SalesByPaymentDaily;
use Magento\Mtf\TestCase\Injectable;

/**
 * Class SaleByPaymentMethodDailyRP57Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodDaily
 */
class SaleByPaymentMethodDailyRP57Test extends Injectable
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
     * SalesByPaymentDaily page.
     *
     * @var SalesByPaymentDaily $salesByPaymentDaily
     */
    protected $salesByPaymentDaily;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param SalesByPaymentDaily $salesByPaymentDaily
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SalesByPaymentDaily $salesByPaymentDaily
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->salesByPaymentDaily = $salesByPaymentDaily;
    }

    /**
     * @param array $shifts
     */
    public function test(array $shifts)
    {
        // Preconditions
        $this->salesByPaymentDaily->open();
        $this->salesByPaymentDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');
        // Steps
        $fromDateBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        $this->salesByPaymentDaily->getFilterBlock()->viewsReport($shifts);
        $this->salesByPaymentDaily->getActionsBlock()->showReport();
        $fromDateAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        self::assertNotEquals(
            $fromDateBefore,
            $fromDateAfter,
            'In Admin Form Sales By Staff WebPOS Page. Time of input from date and to date is not changed.'
        );
    }
}