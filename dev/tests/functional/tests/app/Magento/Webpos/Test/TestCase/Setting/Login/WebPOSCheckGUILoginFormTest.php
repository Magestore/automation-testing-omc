<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/02/2018
 * Time: 08:06
 */

namespace Magento\Webpos\Test\TestCase\Setting\Login;

use Magento\Mtf\TestCase\Injectable;
use Magento\Backend\Test\Page\Adminhtml\Dashboard;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebPOSCheckGUILoginFormTest
 * @package Magento\Webpos\Test\TestCase\Setting\LoginTest
 */
class WebPOSCheckGUILoginFormTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    /* end tags */

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

    /**
     * Run menu navigation test.
     *
     * @param Dashboard $dashboard
     * @param string $menuItem
     * @param bool $waitMenuItemNotVisible
     * @return void
     */
    public function test(Dashboard $dashboard, $menuItem, $waitMenuItemNotVisible = true)
    {
        $dashboard->open();
        $dashboard->getMenuBlock()->navigate($menuItem, $waitMenuItemNotVisible);
        $this->webposIndex->getLoginForm()->waitForLoginForm();
    }
}
