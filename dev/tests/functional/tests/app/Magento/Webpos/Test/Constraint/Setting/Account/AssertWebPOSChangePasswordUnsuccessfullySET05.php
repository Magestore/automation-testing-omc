<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 14:13
 */

namespace Magento\Webpos\Test\Constraint\Setting\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSChangePasswordUnsuccessfullySET05
 * @package Magento\Webpos\Test\Constraint\Setting\Account
 */
class AssertWebPOSChangePasswordUnsuccessfullySET05 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $errorCurrentPasswordMessage, $errorConfirmationPasswordMessage)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            trim($errorCurrentPasswordMessage),
            $webposIndex->getStaffSettingFormMainAccount()->getCurrentPasswordErrorMessage()->getText(),
            'On the Setting General Page - The current password is not correct.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            trim($errorConfirmationPasswordMessage),
            $webposIndex->getStaffSettingFormMainAccount()->getPasswordConfirmErrorMessage()->getText(),
            'On the Setting General Page - The password confirmation could not be blank.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. We could not save the staff with empty password and wrong password confirmation.';
    }
}