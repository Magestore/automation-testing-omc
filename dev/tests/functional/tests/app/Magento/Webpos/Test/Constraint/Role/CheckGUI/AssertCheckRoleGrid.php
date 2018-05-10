<?php
/**
 * Created by PhpStorm.
 * User: bo
 * Date: 08/05/2018
 * Time: 08:53
 */

namespace Magento\Webpos\Test\Constraint\Role\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

/**
 * Class AssertCheckRoleGrid
 * @package Magento\Webpos\Test\Constraint\Role\CheckGUI
 */
class AssertCheckRoleGrid extends AbstractConstraint
{

    public function processAssert(WebposRoleIndex $webposRoleIndex, $title, $buttonNames, $inputFieldNames, $massActions, $filter)
    {
        $this->assertTitle($webposRoleIndex, $title);
        $buttonNames = explode(',', $buttonNames);
        foreach ($buttonNames as $buttonName) {
            $button = trim($buttonName);
            $this->assertActionButtons($webposRoleIndex, $button);
        }
        $massActions = explode(',', $massActions);
        foreach ($massActions as $massAction) {
            $action = trim($massAction);
            $this->assertMassaction($webposRoleIndex, $action);
        }
        $this->assertFilterButton($webposRoleIndex);
    }

    private function assertTitle(WebposRoleIndex $webposRoleIndex, $title)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $title, $webposRoleIndex->getTitleBlock()->getTitle(),
            'Page Title is incorrect'
        );
    }


    private function assertActionButtons(WebposRoleIndex $webposRoleIndex, $button)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposRoleIndex->getRoleGrid()->getButtonByName($button)->isVisible(),
            'Button \'' . $button . '\' show incorrect'
        );
    }

    private function assertMassaction(WebposRoleIndex $webposRoleIndex, $action){
        \PHPUnit_Framework_Assert::assertTrue(
            $webposRoleIndex->getRoleGrid()->getMassActionOptionByName($action)->isPresent(),
            'Action \'' . $action . '\' show incorrect'
        );
    }

    private function assertFilterButton(WebposRoleIndex $webposRoleIndex){
        \PHPUnit_Framework_Assert::assertTrue(
            $webposRoleIndex->getRoleGrid()->getFilterButton()->isVisible(),
            'Filter could n\'t not show'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Backend Role show is correct";
    }
}