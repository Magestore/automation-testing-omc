<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/02/2018
 * Time: 08:15
 */

namespace Magento\Webpos\Test\Constraint\Setting\Login;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSCheckGUILoginFormOPenFromAdmin
 * @package Magento\Webpos\Test\Constraint\Setting\LoginTest
 */
class AssertWebPOSCheckGUILoginFormOPenFromAdmin extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getLoginForm()->isVisible(),
            'On the WebPOS LoginTest Page. The LoginTest Form was not visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getLoginForm()->getLogo()->isVisible(),
            'On the WebPOS LoginTest Page. Logo was not visible correctly'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getLoginForm()->getUsernameField()->isVisible(),
            'On the WebPOS LoginTest Page. Username Field was not visible correctly'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getLoginForm()->getPasswordField()->isVisible(),
            'On the WebPOS LoginTest Page. Username Field was not visible correctly'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the WebPOS LoginTest Page. LoginTest Form, Logo, Username Field, Password Field were visible correctly.';
    }
}