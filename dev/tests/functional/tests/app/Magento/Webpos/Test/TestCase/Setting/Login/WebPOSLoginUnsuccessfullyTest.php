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
 */
class WebPOSLoginUnsuccessfullyTest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;


    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($username, $password)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->getUsernameField()->setValue($username);
        $this->webposIndex->getLoginForm()->getPasswordField()->setValue($password);
        $this->webposIndex->getLoginForm()->clickLoginButton();
    }
}
