<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/11/18
 * Time: 4:46 PM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

class AssertMappingLocationModalShow extends AbstractConstraint
{

    public function processAssert(MappingLocationIndex $mappingLocationIndex){
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getLocationModal()->isVisible(),
            'Location Modal could n\'t show'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Location modal is showed';
    }
}