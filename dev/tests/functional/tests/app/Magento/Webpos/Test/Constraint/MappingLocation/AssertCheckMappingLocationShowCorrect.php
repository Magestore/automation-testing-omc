<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/11/18
 * Time: 9:18 AM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

class AssertCheckMappingLocationShowCorrect extends AbstractConstraint
{

    public function processAssert(MappingLocationIndex $mappingLocationIndex){
        $title = 'Create a new Warehouse';
        \PHPUnit_Framework_Assert::assertFalse(
            $mappingLocationIndex->getMappingLocationGrid()->getWarehouseByTitle($title)->isVisible(),
            'Exist least one Location with no Warehouse'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Mapping Location show correct';
    }
}