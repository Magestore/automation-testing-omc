<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/7/2018
 * Time: 3:00 PM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;

use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertLocationOnGridModalCorrectly
 * @package Magento\Webpos\Test\Constraint\MappingLocation
 */
class AssertLocationOnGridModalCorrectly extends AbstractConstraint
{
    /**
     * @param MappingLocationIndex $mappingLocationIndex
     * @param Location $location
     */
    public function processAssert(MappingLocationIndex $mappingLocationIndex, $location)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $location->getDisplayName(),
            $mappingLocationIndex->getLocationModal()->getFilterFirstDisplayName()->getText(),
            'Location information is not correct.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $location->getAddress(),
            $mappingLocationIndex->getLocationModal()->getFilterFirstAddress()->getText(),
            'Location information is not correct.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $location->getDescription(),
            $mappingLocationIndex->getLocationModal()->getFilterFirstDescription()->getText(),
            'Location information is not correct.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Location information is correct';
    }
}