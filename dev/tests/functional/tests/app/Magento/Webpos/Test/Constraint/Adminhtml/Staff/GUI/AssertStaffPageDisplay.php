<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 02/05/2018
 * Time: 08:45
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\GUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

class AssertStaffPageDisplay extends AbstractConstraint
{
    const ERROR_TEXT = '404 Error';

    public function processAssert(StaffIndex $staffIndex, $pageTitle, $nameInputFields, $actionNames)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $pageTitle,
            $staffIndex->getTitleBlock()->getTitle(),
            'Staff - Title is not shown'
        );

        \PHPUnit_Framework_Assert::assertNotContains(
            self::ERROR_TEXT,
            $staffIndex->getErrorBlock()->getContent(),
            "404 Error is displayed on '$pageTitle' page."
        );

        \PHPUnit_Framework_Assert::assertTrue(
            $staffIndex->getGridPageActionBlock()->isVisible(),
            'Button add staff does not display'
        );

        $nameInputFields = explode(', ', $nameInputFields);
        foreach ($nameInputFields as $nameInputField) {
            \PHPUnit_Framework_Assert::assertTrue(
                $staffIndex->getStaffsGrid()->columnIsVisible($nameInputField),
                'Field ' . $nameInputField . ' does not display'
            );
        }

        $actionNames = explode(', ', $actionNames);
        foreach ($actionNames as $actionName) {
            \PHPUnit_Framework_Assert::assertTrue(
                $staffIndex->getGridHeader()->gridHeaderContainActionName($actionName),
                'Action ' . $actionName . ' does not display'
            );
        }

        \PHPUnit_Framework_Assert::assertTrue(
            $staffIndex->getGridHeader()->gridHeaderContainFilter(),
            'Filter does not display'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Mange Staff admin Page is display correctly";
    }
}