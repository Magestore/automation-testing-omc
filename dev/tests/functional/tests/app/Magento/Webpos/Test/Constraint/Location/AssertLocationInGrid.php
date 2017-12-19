<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 09:12:40
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-07 09:34:56
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\Location;

use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertLocationInGrid
 */
class AssertLocationInGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'high';
    /* end tags */

    /**
     * @param Staff Location Index
     */
    protected $locationIndex;
    /**
     * Assert locatiom availability in locatiom grid
     *
     * @param Locatiom $locatiom
     * @param LocationIndex $locationIndex
     * @return void
     */
    public function processAssert(Location $location, LocationIndex $locationIndex)
    {
        $filter = ['display_name' => $location->getDisplayName()];
        $locationIndex->open();
        \PHPUnit_Framework_Assert::assertTrue(
            $locationIndex->getLocationsGrid()->isRowVisible($filter),
            'AssertWebposCheckGUICustomerPriceCP54 Staff Location with Display Name \'' . $location->getDisplayName() . '\' is absent in AssertWebposCheckGUICustomerPriceCP54 Location Location grid.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'AssertWebposCheckGUICustomerPriceCP54 Staff Location is present in AssertWebposCheckGUICustomerPriceCP54 Staff timezone_location_get() grid.';
    }
}

