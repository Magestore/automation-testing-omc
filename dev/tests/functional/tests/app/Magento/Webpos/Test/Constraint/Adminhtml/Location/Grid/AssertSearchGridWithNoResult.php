<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/10/18
 * Time: 9:23 AM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertSearchGridWithNoResult extends AbstractConstraint
{

    public function processAssert(LocationIndex $locationIndex, $location)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $locationIndex->getLocationsGrid()->isRowVisible([
                'display_name' => $location->getDisplayName()
            ]),
            'Location ' . $location->getDisplayName() . ' is still exist'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Searched location could not display";
    }
}