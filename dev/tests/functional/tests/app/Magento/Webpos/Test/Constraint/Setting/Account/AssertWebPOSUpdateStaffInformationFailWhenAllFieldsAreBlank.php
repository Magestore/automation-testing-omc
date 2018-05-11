<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 13:20
 */

namespace Magento\Webpos\Test\Constraint\Setting\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSUpdateStaffInformationFailWhenAllFieldsAreBlank
 * @package Magento\Webpos\Test\Constraint\Setting\Account
 */
class AssertWebPOSUpdateStaffInformationFailWhenAllFieldsAreBlank extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $displayNameMessage, $passwordMessage)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $displayNameMessage,
            $webposIndex->getStaffSettingFormMainAccount()->getDisplayNameErrorMessage()->getText(),
            'On the Setting General Page - The current staff name is required'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $passwordMessage,
            $webposIndex->getStaffSettingFormMainAccount()->getCurrentPasswordErrorMessage()->getText(),
            'On the Setting General Page - The current password is required.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. We could not update staff information when all fields are blank.';
    }
}