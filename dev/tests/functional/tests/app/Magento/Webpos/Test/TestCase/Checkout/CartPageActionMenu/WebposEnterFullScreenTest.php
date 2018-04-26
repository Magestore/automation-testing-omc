<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/12/2017
 * Time: 09:45
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPageActionMenu;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposEnterFullScreenTest
 *
 * Pre: 1. Login Webpos as a staff
 * Step: "1. Click on action menu ""..."" on the top-right of the screen
2. Click on ""Enter/exit fullscreen mode""  "
 * Accept: Webpos will be displayed full screen mode
 *
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\CategoryRepository\CartPageActionMenu
 */
class WebposEnterFullScreenTest extends Injectable
{
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
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
        $minHeightBefore = $this->webposIndex->getBody()->getPageStyleMinHeight();
        $this->webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
        $this->webposIndex->getCheckoutFormAddNote()->waitFullScreenMode();
        $this->webposIndex->getCheckoutFormAddNote()->getFullScreenMode()->click();
        return ['minHeightBefore' => $minHeightBefore];
    }
}