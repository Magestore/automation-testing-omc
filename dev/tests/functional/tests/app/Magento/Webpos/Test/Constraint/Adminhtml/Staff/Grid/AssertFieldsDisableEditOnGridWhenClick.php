<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 22/02/2018
 * Time: 09:05
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Grid;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Staff;

class AssertFieldsDisableEditOnGridWhenClick extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffIndex $staffIndex
     * @return void
     */
    public function processAssert(StaffIndex $staffIndex, $nameInputFields, $nameSelectFields, $dataDisplay)
    {
        //check all fields enable editing hide
        $nameInputFields = explode(', ', $nameInputFields);
        foreach ($nameInputFields as $nameInputField)
        {
            \PHPUnit_Framework_Assert::assertFalse(
                $staffIndex->getStaffsGrid()->getInputFieldEdtingByName($nameInputField)->isVisible(),
                'Field '.$nameInputField.' does not back to origin status'
            );
        }
        $nameSelectFields = explode(', ', $nameSelectFields);
        foreach ($nameSelectFields as $nameSelectField)
        {
            \PHPUnit_Framework_Assert::assertFalse(
                $staffIndex->getStaffsGrid()->getSelectFieldEdtingByName($nameSelectField)->isVisible(),
                'Field '.$nameSelectField.' does not back to origin status'
            );
        }

        //check all fields disable editing display
        foreach ($dataDisplay as $key => $value)
        {
            \PHPUnit_Framework_Assert::assertTrue(
                $staffIndex->getStaffsGrid()->getFieldDisableEditingDisplay($value)->isVisible(),
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
