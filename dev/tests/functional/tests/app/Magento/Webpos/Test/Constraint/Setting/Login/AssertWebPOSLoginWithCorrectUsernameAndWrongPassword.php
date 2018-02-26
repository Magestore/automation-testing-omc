<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/02/2018
 * Time: 08:38
 */

namespace Magento\Webpos\Test\Constraint\Setting\Login;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSLoginWithCorrectUsernameAndWrongPassword
 * @package Magento\Webpos\Test\Constraint\Setting\Login
 */
class AssertWebPOSLoginWithCorrectUsernameAndWrongPassword extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $message)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            'On the WebPOS Login Page. We should not login with the valid username and invalid password.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the WebPOS Login Page. We should not login with the valid username and invalid password.';
    }
}