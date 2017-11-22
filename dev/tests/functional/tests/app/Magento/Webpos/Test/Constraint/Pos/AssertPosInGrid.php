<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-08 11:26:20
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-08 13:11:26
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\Pos;

use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertPosInGrid
 */
class AssertPosInGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'high';
    /* end tags */

    /**
     * @param Pos Index
     */
    protected $posIndex;
    /**
     * Assert pos availability in pos grid
     *
     * @param Pos $pos
     * @param PosIndex $posIndex
     * @return void
     */
    public function processAssert(Pos $pos, PosIndex $posIndex)
    {
        $filter = ['pos_name' => $pos->getPosName()];
        $posIndex->open();
        \PHPUnit_Framework_Assert::assertTrue(
            $posIndex->getPosGrid()->isRowVisible($filter),
            'Webpos Pos with Pos Name \'' . $pos->getPosName() . '\' is absent in Webpos Pos grid.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Webpos Pos is present in Webpos Pos timezone_location_get() grid.';
    }
}
