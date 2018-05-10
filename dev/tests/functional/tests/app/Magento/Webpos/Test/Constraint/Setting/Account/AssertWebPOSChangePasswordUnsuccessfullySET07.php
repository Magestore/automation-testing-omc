<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 14:21
 */

namespace Magento\Webpos\Test\Constraint\Setting\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSChangePasswordUnsuccessfullySET07
 * @package Magento\Webpos\Test\Constraint\Setting\Account
 */
class AssertWebPOSChangePasswordUnsuccessfullySET07 extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $errorNewPasswordMessage)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $errorNewPasswordMessage,
            $webposIndex->getStaffSettingFormMainAccount()->getNewPasswordErrorMessage()->getText(),
            'On the Setting General Page - The new and current password must be 7 or more characters, using both numeric and alphabetic.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. The new and current password must be 7 or more characters, using both numeric and alphabetic. We could not update password';
    }
}