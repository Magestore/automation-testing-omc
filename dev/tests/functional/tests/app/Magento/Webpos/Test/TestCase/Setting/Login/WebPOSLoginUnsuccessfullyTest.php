<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/02/2018
 * Time: 08:20
 */

namespace Magento\Webpos\Test\TestCase\Setting\Login;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSLoginUnsuccessfullyTest
 * @package Magento\Webpos\Test\TestCase\Setting\LoginTest
 * SET26
 * Steps
 * 1. Go to Webpos login form
 * 2. Click on [Login] button
 * Acceptance Criteria
 * 2.
 * - Login unsuccessfully
 * - Show message: ""This is a required field."" on the right of 2 textboxes [Username] and [Password]
 *
 * SET27
 * Steps
 * 1. Go to Webpos login form
 * 2. Enter incorrect username and password
 * 3. Click on [Login] button
 * Acceptance Criteria
 * 3.
 * - Login unsuccessfully
 * - Display warning :"" Warning: Your login information is wrong!""
 *
 * SET28
 * Steps
 * 1. Go to Webpos login form
 * 2. Enter correct username and wrong password
 * 3. Click on [Login] button
 * Acceptance Criteria
 * 3.
 * - Login unsuccessfully
 * - Display warning :"" Warning: Your login information is wrong!""
 */
class WebPOSLoginUnsuccessfullyTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $username
     * @param $password
     */
    public function test($username, $password)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->getUsernameField()->setValue($username);
        $this->webposIndex->getLoginForm()->getPasswordField()->setValue($password);
        $this->webposIndex->getLoginForm()->clickLoginButton();
    }
}
