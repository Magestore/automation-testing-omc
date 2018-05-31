<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/02/2018
 * Time: 08:06
 */

namespace Magento\Webpos\Test\TestCase\Setting\Login;

use Magento\Backend\Test\Page\Adminhtml\Dashboard;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSCheckGUILoginFormTest
 * @package Magento\Webpos\Test\TestCase\Setting\LoginTest
 * Steps
 * 1. Go to backend
 * 2. Webpos > POS checkout
 *
 * Acceptance Criteria
 * 2.
 * - Redirect to webpos page and display Login form
 * - On Login form show logo and required enter username, password to login webpos
 */
class WebPOSCheckGUILoginFormTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    /* end tags */

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
     * Run menu navigation test.
     *
     * @param Dashboard $dashboard
     * @param $menuItem
     * @param bool $waitMenuItemNotVisible
     */
    public function test(
        Dashboard $dashboard,
        $menuItem,
        $waitMenuItemNotVisible = true
    )
    {
        $dashboard->open();
        $dashboard->getMenuBlock()->navigate($menuItem, $waitMenuItemNotVisible);
        $this->webposIndex->getLoginForm()->waitForLoginForm();
    }
}
