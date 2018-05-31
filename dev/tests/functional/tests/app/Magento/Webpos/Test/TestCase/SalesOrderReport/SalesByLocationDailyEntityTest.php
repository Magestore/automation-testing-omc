<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-12 15:34:16
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:26:49
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Page\Adminhtml\SalesByLocationDaily;

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
class SalesByLocationDailyEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * SalesByLocationDaily page.
     *
     * @var SalesByLocationDaily $salesByLocationDaily
     */
    protected $salesByLocationDaily;

    /**
     * Inject pages.
     *
     * @param SalesByLocationDaily $salesByLocationDaily
     * @return void
     */
    public function __inject(SalesByLocationDaily $salesByLocationDaily)
    {
        $this->salesByLocationDaily = $salesByLocationDaily;
    }

    /**
     * Bestseller Products Report.
     *
     * @param Shift $shift
     * @param array $shifts
     * @return void
     */
    public function test(array $shifts)
    {
        // Preconditions
        $this->salesByLocationDaily->open();
        $this->salesByLocationDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        // Steps
        $this->salesByLocationDaily->getFilterBlock()->viewsReport($shifts);
        $this->salesByLocationDaily->getActionsBlock()->showReport();
    }
}
