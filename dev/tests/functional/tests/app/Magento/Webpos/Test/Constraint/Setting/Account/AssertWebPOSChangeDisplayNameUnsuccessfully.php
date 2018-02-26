<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 13:35
 */

namespace Magento\Webpos\Test\Constraint\Setting\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSChangeDisplayNameUnsuccessfully
 * @package Magento\Webpos\Test\Constraint\Setting\Account
 */
class AssertWebPOSChangeDisplayNameUnsuccessfully extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $errorMessage)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $errorMessage,
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            'On the Account Setting General Page - We could not save the staff with wrong current password.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. We could not save the staff with wrong current password.';
    }
}