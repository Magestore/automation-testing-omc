<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/3/18
 * Time: 11:13 AM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertSearchExistLocationSuccess extends AbstractConstraint
{

    public function processAssert(LocationIndex $locationIndex, $locationData){
        $locationIndex->getLocationsGrid()->waitLoader();
        $locationIndex->getLocationsGrid()->search([
            'display_name' => $locationData['display_name']
        ]);
        $locationIndex->getLocationsGrid()->waitLoader();
        \PHPUnit_Framework_Assert::assertTrue(
            $locationIndex->getLocationsGrid()->getDataGridFirstRow()->isVisible(),
            'Search Location is incorrect'
        );

        $locationIndex->getLocationsGrid()->resetFilter();
        $locationIndex->getLocationsGrid()->waitLoader();
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Search location is success';
    }
}