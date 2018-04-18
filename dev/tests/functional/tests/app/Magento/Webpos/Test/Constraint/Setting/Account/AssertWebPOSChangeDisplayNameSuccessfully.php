<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 13:48
 */

namespace Magento\Webpos\Test\Constraint\Setting\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSChangeDisplayNameSuccessfully
 * @package Magento\Webpos\Test\Constraint\Setting\Account
 */
class AssertWebPOSChangeDisplayNameSuccessfully extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $successMessage)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $successMessage,
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            'On the Account Setting General Page - We updated the display name staff with valid password successfully.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. We updated the display name staff with valid password successfully.';
    }
}