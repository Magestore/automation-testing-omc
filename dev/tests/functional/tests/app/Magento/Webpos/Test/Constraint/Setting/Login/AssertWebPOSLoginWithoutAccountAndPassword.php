<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/02/2018
 * Time: 08:24
 */

namespace Magento\Webpos\Test\Constraint\Setting\Login;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSLoginWithoutAccountAndPassword
 * @package Magento\Webpos\Test\Constraint\Setting\Login
 */
class AssertWebPOSLoginWithoutAccountAndPassword extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $message)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $webposIndex->getLoginForm()->getUsernameErrorMessage()->getText(),
            'On the WebPOS Login Page. We should not login with not fill in username and password.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $webposIndex->getLoginForm()->getPasswordErrorMessage()->getText(),
            'On the WebPOS Login Page. We should not login with not fill in username and password.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the WebPOS Login Page. We should not login with not fill in username and password.';
    }
}