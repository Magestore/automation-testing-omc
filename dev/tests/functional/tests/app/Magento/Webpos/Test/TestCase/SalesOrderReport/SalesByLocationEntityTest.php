<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-12 15:28:23
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:27:08
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport;

use Magento\Webpos\Test\Page\Adminhtml\SalesByLocation;
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
class SalesByLocationEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * SalesByLocation page.
     *
     * @var SalesByLocation
     */
    protected $salesByLocation;

    /**
     * Inject pages.
     *
     * @param SalesByStaffDaily $salesByLocation
     * @return void
     */
    public function __inject(SalesByLocation $salesByLocation)
    {
        $this->salesByLocation = $salesByLocation;
    }

    /**
     * Bestseller Products Report.
     *
     * @param Shift $shift
     * @param array $shifts
     * @return void
     */
    public function test(Shift $shift, array $shifts)
    {
        // Preconditions
//        $shift->persist();
        $this->salesByLocation->open();
        $this->salesByLocation->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        // Steps
        $this->salesByLocation->getFilterBlock()->viewsReport($shifts);
        $this->salesByLocation->getActionsBlock()->showReport();
    }
}
