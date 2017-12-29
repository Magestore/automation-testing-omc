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
        for ($i=0; $i<2; $i++) {
            $this->webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
            $this->webposIndex->getCheckoutFormAddNote()->waitFullScreenMode();
            $this->webposIndex->getCheckoutFormAddNote()->getFullScreenMode()->click();
        }
    }
}