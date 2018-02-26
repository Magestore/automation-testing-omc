<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 11:11
 */

namespace Magento\Webpos\Test\Constraint\Setting\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertWebPOSCheckGUIMyAccountPageDisplayCorrectly
 * @package Magento\Webpos\Test\Constraint\Setting\Account
 */
class AssertWebPOSCheckGUIMyAccountPageDisplayCorrectly extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $username)
    {
        \PHPUnit_Framework_Assert::assertContains(
            $username,
            $webposIndex->getStaffSettingFormMainAccount()->getDisplayName()->getValue(),
            'On the Setting General Page - The current staff name was not visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getStaffSettingFormMainAccount()->getCurrentPassword()->isVisible(),
            'On the Setting General Page - The Current Password Field was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getStaffSettingFormMainAccount()->getPassword()->isVisible(),
            'On the Setting General Page - The Password Field was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getStaffSettingFormMainAccount()->getPasswordConfirmation()->isVisible(),
            'On the Setting General Page - The Password Confirmation Field was not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. Everything were displayed correctly.';
    }
}