<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/12/2017
 * Time: 10:15
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPageActionMenu;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposExitFullScreenTest
 * @package Magento\WebposCheckGUICustomerPriceCP54EntityTest\Test\TestCase\CategoryRepository\CartPageActionMenu
 *
 * Precondition:
 * 1. Login Webpos as a staff
 *
 * Steps:
 * "1. Click on action menu ""..."" on the top-right of the screen
 * 2. Click on ""Enter/exit fullscreen mode""
 * 3. Click on ""Enter/exit fullscreen mode"" again"
 *
 * Acceptance:
 * Exit full screen mode
 *
 */
class WebposExitFullScreenTest extends Injectable
{
    /**
     * WebposCheckGUICustomerPriceCP54EntityTest Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Runs the scenario test case
     *
     * @return void
     */
    public function test()
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        for ($i = 0; $i < 2; $i++) {
            $this->webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
            $this->webposIndex->getCheckoutFormAddNote()->waitFullScreenMode();
            $this->webposIndex->getCheckoutFormAddNote()->getFullScreenMode()->click();
        }
    }
}