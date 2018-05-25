<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-12 14:00:46
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:27:53
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport;

use Magento\Webpos\Test\Page\Adminhtml\SalesByStaff;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Mtf\TestCase\Injectable;
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
class SalesByStaffEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * SalesByStaff page.
     *
     * @var SalesByStaff
     */
    protected $salesByStaff;

    /**
     * Inject pages.
     *
     * @param SalesByStaff $salesByStaff
     * @return void
     */
    public function __inject(SalesByStaff $salesByStaff)
    {
        $this->salesByStaff = $salesByStaff;
    }

    /**
     * Bestseller Products Report.
     *
     * @param Shift $shift
     * @param array $salesByStaffReport
     * @return void
     */
    public function test(array $shifts)
    {
        // Preconditions
        $this->salesByStaff->open();
        $this->salesByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        // Steps
        $this->salesByStaff->getFilterBlock()->viewsReport($shifts);
        $this->salesByStaff->getActionsBlock()->showReport();
    }
}
