<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 22/02/2018
 * Time: 09:05
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertFieldsDisableEditOnGridWhenClick extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param LocationIndex
     * @return void
     */
    public function processAssert(LocationIndex $locationIndex, $nameInputFields, $dataDisplay)
    {
        //check all fields enable editing hide
        $nameInputFields = explode(', ', $nameInputFields);
        foreach ($nameInputFields as $nameInputField)
        {
            \PHPUnit_Framework_Assert::assertFalse(
                $locationIndex->getLocationsGrid()->getInputFieldEdtingByName($nameInputField)->isVisible(),
                'Field '.$nameInputField.' does not back to origin status'
            );
        }

        //check all fields disable editing display
        foreach ($dataDisplay as $key => $value)
        {
            \PHPUnit_Framework_Assert::assertTrue(
                $locationIndex->getLocationsGrid()->getFieldDisableEditingDisplay($value)->isVisible(),
                'Field '.$key.' does not display'
            );
        }
    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Fields back to origin status';
    }
}
