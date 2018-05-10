<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/2/18
 * Time: 10:41 AM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

/**
 * Class AssertFilterFormHidden
 * @package Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid
 */
class AssertFilterFormHidden extends AbstractConstraint
{
    public function processAssert(LocationIndex $locationIndex){
        \PHPUnit_Framework_Assert::assertFalse(
            $locationIndex->getLocationsGrid()->getGridFilterForm()->isVisible(),
            'Filter is still visible'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Location Grid Filter Form is closed";
    }
}