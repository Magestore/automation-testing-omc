<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4/27/18
 * Time: 10:52 AM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertManageLocationIndexPage extends AbstractConstraint
{
    public function processAssert(LocationIndex $locationIndex, $inputFieldNames, $massActions)
    {
        $inputFieldNames = explode(',', $inputFieldNames);
        foreach ($inputFieldNames as $fieldName) {
            $fieldName = trim($fieldName);
            \PHPUnit_Framework_Assert::assertTrue(
                $locationIndex->getLocationsGrid()->getInputFieldGridByName($fieldName)->isVisible(),
                'Fields ' . $fieldName . 'does n\'t show correctly!'
            );
        }
//        var_dump($massActions);die();
        /*Mass Action*/
        $massActions = explode(',', $massActions);
        foreach ($massActions as $action){
            $action =  trim($action);
            \PHPUnit_Framework_Assert::assertTrue(
                $locationIndex->getLocationsGrid()->getMassActionOptionByName($action)->isPresent(),
                'Mass Action '.$action.' does n\'t display'
            );
        }


        /*Filter funtion*/
        \PHPUnit_Framework_Assert::assertTrue(
            $locationIndex->getLocationsGrid()->getFilterButton()->isVisible(),
            'Filter could n\'t enable'
        );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Page manage location shows correct';
    }
}