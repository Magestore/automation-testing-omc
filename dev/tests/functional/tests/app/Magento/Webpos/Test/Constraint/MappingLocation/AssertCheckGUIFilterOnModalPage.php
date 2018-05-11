<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/7/2018
 * Time: 11:17 AM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;

use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCheckGUIFilterOnModalPage extends AbstractConstraint
{
    /**
     * @param MappingLocationIndex $mappingLocationIndex
     */
    public function processAssert(MappingLocationIndex $mappingLocationIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getLocationModal()->getFieldIdFrom()->isVisible(),
            'Field Id From is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getLocationModal()->getFieldIdTo()->isVisible(),
            'Field Id To is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getLocationModal()->getFieldDisplayName()->isVisible(),
            'Display Name is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getLocationModal()->getFieldAddress()->isVisible(),
            'Address is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getLocationModal()->getFieldDescription()->isVisible(),
            'Description is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getLocationModal()->getCancelButtonFilter()->isVisible(),
            'Button Cancel is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getLocationModal()->getApplyButtonFilter()->isVisible(),
            'Button Apply is not visible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Choose Locations Modal is correctly.';
    }
}