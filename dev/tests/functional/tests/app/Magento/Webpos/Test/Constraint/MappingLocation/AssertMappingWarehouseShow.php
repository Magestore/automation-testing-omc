<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/10/18
 * Time: 2:36 PM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

class AssertMappingWarehouseShow extends AbstractConstraint
{

    public function processAssert(MappingLocationIndex $mappingLocationIndex){
       \PHPUnit_Framework_Assert::assertTrue([
           
       ]);
        $mappingLocationIndex->getMappingLocationGrid()->getFirstData()->isVisible();
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Mapping Location Page could show correct';
    }
}