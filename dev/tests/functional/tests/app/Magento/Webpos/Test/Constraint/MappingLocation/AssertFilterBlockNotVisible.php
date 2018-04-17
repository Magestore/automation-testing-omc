<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/7/2018
 * Time: 2:10 PM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;

use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertFilterBlockNotVisible
 * @package Magento\Webpos\Test\Constraint\MappingLocation
 */
class AssertFilterBlockNotVisible extends AbstractConstraint
{
    /**
     * @param MappingLocationIndex $mappingLocationIndex
     */
    public function processAssert(MappingLocationIndex $mappingLocationIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $mappingLocationIndex->getLocationModal()->getFilterBlock()->isVisible(),
            'Filter Block is visible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Locations Modal - Filter Block is correctly.';
    }
}