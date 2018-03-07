<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/7/2018
 * Time: 3:00 PM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;

use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertLocationShownOnGridModal
 * @package Magento\Webpos\Test\Constraint\MappingLocation
 */
class AssertLocationShownOnGridModal extends AbstractConstraint
{
    /**
     * @param MappingLocationIndex $mappingLocationIndex
     */
    public function processAssert(MappingLocationIndex $mappingLocationIndex)
    {
        // Show on Modal "Choose Locations"
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getLocationModal()->getFilterFirstId()->isVisible(),
            'Location not shown on the grid modal.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Location shown on the grid modal.';
    }
}