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

class AssertFieldsEnableEditOnGridWhenClick extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffIndex $staffIndex
     * @return void
     */
    public function processAssert(StaffIndex $staffIndex, $nameInputFields, $nameSelectFields)
    {
        $nameInputFields = explode(', ', $nameInputFields);
        foreach ($nameInputFields as $nameInputField)
        {
            \PHPUnit_Framework_Assert::assertTrue(
                $staffIndex->getStaffsGrid()->getInputFieldEdtingByName($nameInputField)->isVisible(),
                'Field '.$nameInputField.' does not edit'
            );
        }

        $nameSelectFields = explode(', ', $nameSelectFields);
        foreach ($nameSelectFields as $nameSelectField)
        {
            \PHPUnit_Framework_Assert::assertTrue(
                $staffIndex->getStaffsGrid()->getSelectFieldEdtingByName($nameSelectField)->isVisible(),
                'Field '.$nameSelectField.' does not edit'
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
        return 'Fields can edit';
    }
}
