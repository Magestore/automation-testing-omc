<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/7/2018
 * Time: 9:23 AM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;

use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertMappingLocationSuccessSaveMessage
 * @package Magento\Webpos\Test\Constraint\MappingLocation
 */
class AssertMappingLocationSuccessSaveMessage extends AbstractConstraint
{
    /**
     *
     */
    const SUCCESS_MESSAGE = 'The mapping warehouses - locations have been saved.';

    /**
     * @param MappingLocationIndex $mappingLocationIndex
     */
    public function processAssert(MappingLocationIndex $mappingLocationIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_MESSAGE,
            $mappingLocationIndex->getMessagesBlock()->getMessagesBlock(),
            'Wrong success message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Mapping Locations - Success message is displayed.';
    }
}