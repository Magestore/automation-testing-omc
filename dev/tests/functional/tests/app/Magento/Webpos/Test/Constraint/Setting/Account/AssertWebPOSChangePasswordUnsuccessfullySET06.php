<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 14:17
 */

namespace Magento\Webpos\Test\Constraint\Setting\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSChangePasswordUnsuccessfullySET06
 * @package Magento\Webpos\Test\Constraint\Setting\Account
 */
class AssertWebPOSChangePasswordUnsuccessfullySET06 extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $errorCurrentPasswordMessage)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $errorCurrentPasswordMessage,
            $webposIndex->getStaffSettingFormMainAccount()->getCurrentPasswordErrorMessage()->getText(),
            'On the Setting General Page - The current staff name is not correct.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. We could not update the staff information with wrong current password.';
    }
}