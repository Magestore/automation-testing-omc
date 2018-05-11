<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/02/2018
 * Time: 08:35
 */

namespace Magento\Webpos\Test\Constraint\Setting\Login;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSLoginWithIncorrectUsernameAndPassword
 * @package Magento\Webpos\Test\Constraint\Setting\Login
 */
class AssertWebPOSLoginWithIncorrectUsernameAndPassword extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex, $message)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            'On the WebPOS Login Page. We should not login with ivnalid username and password.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the WebPOS Login Page. We should not login with ivnalid username and password.';
    }
}