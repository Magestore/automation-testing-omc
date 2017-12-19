<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-12 10:03:48
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:30:43
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Shift;

use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Page\Adminhtml\ShiftIndex;
use Magento\Mtf\TestCase\Injectable;

/**
 * Preconditions:
 * 1. Print AssertWebposCheckGUICustomerPriceCP54 Shift.
 *
 * Steps:
 * 1. Login to backend.
 * 2. Open Sales -> AssertWebposCheckGUICustomerPriceCP54 -> Z-Report.
 * 3. Click print
 * 5. Perform all asserts.
 *
 * @group Pos(PS)
 * @ZephyrId MAGETWO-28459
 */
class PrintShiftEntityTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'CS';
    /* end tags */

    /**
     * @var ShiftIndex
     */
    protected $shiftIndexPage;

    /**
     * Preparing pages for test
     *
     * @param ShiftIndex $shiftIndexPage
     * @return void
     */
    public function __inject(
        ShiftIndex $shiftIndexPage
    )
    {
        $this->shiftIndexPage = $shiftIndexPage;
    }

    /**
     * Runs Delete Shift Backend Entity test
     *
     * @param Shift $shift
     * @return void
     */
    public function testPrintShiftEntity(Shift $shift)
    {
        // Preconditions:
        $shift->persist();

        // Steps:
        $filter = ['shift_id' => $shift->getShiftId()];
        $this->shiftIndexPage->open();
        $this->shiftIndexPage->getShiftGrid()->searchAndOpen($filter);
    }
}

