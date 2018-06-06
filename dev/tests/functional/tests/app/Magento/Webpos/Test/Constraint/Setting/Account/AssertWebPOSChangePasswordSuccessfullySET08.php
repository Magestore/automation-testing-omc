<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 14:27
 */

namespace Magento\Webpos\Test\Constraint\Setting\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSChangePasswordSuccessfullySET08
 * @package Magento\Webpos\Test\Constraint\Setting\Account
 */
class AssertWebPOSChangePasswordSuccessfullySET08 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $successMessage)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            trim($successMessage),
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            'On the Account Setting General Page - We updated the password staff unsuccessfully. Please check again'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. We updated the password staff successfully.';
    }
}