<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/2/18
 * Time: 1:24 PM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertGridFilterNoResult extends AbstractConstraint
{

    public function processAssert(LocationIndex $locationIndex){
        \PHPUnit_Framework_Assert::assertFalse(
            $locationIndex->getLocationsGrid()->getDataGridFirstRow()->isVisible(),
            'Error Filter'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Data grid is empty';
    }
}