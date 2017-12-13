<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 11:29:23
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-07 13:09:04
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\Location;

use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertLocationTermNotInGrid extends AbstractConstraint
{
    /**
     * Assert that after delete a search term on grid page not displayed
     *
     * @param LocationIndex $indexPage
     * @param Location $locationTerm
     * @return void
     */
    public function processAssert(LocationIndex $indexPage, Location $locationTerm)
    {
        $locationText = $locationTerm->getDisplayName();
        $grid = $indexPage->open()->getLocationsGrid();
        $filters = [
            'webpos_staff_location' => $locationText,
            'location_id' => $locationTerm->getLocationId(),
            'display_name' => $locationTerm->getDisplayName(),
            'address' => $locationTerm->getAddress(),
            'description' => $locationTerm->getDescription(),
        ];

        $grid->search($filters);
        unset($filters['store_id']);
        \PHPUnit_Framework_Assert::assertFalse(
            $grid->isRowVisible($filters, false),
            'AssertWebposCheckGUICustomerPriceCP54 Staff Location "' . $locationText . '" was found in grid.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'AssertWebposCheckGUICustomerPriceCP54 Staff Location was not found in grid.';
    }
}
