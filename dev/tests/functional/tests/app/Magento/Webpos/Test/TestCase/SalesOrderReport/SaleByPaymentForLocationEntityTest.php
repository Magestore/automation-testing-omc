<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-12 16:13:23
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:26:38
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport;

use Magento\Webpos\Test\Page\Adminhtml\SaleByPaymentForLocation;
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
class SaleByPaymentForLocationEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * SaleByPaymentForLocation page.
     *
     * @var SaleByPaymentForLocation
     */
    protected $saleByPaymentForLocation;

    /**
     * Inject pages.
     *
     * @param SaleByPaymentForLocation $saleByPaymentForLocation
     * @return void
     */
    public function __inject(SaleByPaymentForLocation $saleByPaymentForLocation)
    {
        $this->saleByPaymentForLocation = $saleByPaymentForLocation;
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
        $this->saleByPaymentForLocation->open();
        $this->saleByPaymentForLocation->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        // Steps
        $this->saleByPaymentForLocation->getFilterBlock()->viewsReport($shifts);
        $this->saleByPaymentForLocation->getActionsBlock()->showReport();
    }
}

