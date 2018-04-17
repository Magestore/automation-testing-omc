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

class AssertFieldsEnableEditOnGridWhenClick extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param LocationIndex
     * @return void
     */
    public function processAssert(LocationIndex $locationIndex, $nameInputFields)
    {
        $nameInputFields = explode(', ', $nameInputFields);
        foreach ($nameInputFields as $nameInputField)
        {
            \PHPUnit_Framework_Assert::assertTrue(
                $locationIndex->getLocationsGrid()->getInputFieldEdtingByName($nameInputField)->isVisible(),
                'Field '.$nameInputField.' does not edit'
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
