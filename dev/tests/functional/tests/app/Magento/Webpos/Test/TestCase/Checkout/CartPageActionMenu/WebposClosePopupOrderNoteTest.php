<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/12/2017
 * Time: 17:30
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPageActionMenu;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposClosePopupOrderNoteTest
 * @package Magento\WebposCheckGUICustomerPriceCP54EntityTest\Test\TestCase\CategoryRepository\CartPageActionMenu
 *
 * Precondition:
 * 1. Login Webpos as a staff
 *
 * Steps:
 * "1. Click on action menu ""..."" on the top-right of the screen
 * 2. Click on ""Add order note""
 * 3. Click on ""Cancel"" button"
 *
 * Acceptance:
 * Close "Order comment" popup
 *
 */
class WebposClosePopupOrderNoteTest extends Injectable
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

        $this->webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
        $this->webposIndex->getCheckoutFormAddNote()->getAddOrderNote()->click();

        sleep(2);
        $this->webposIndex->getCheckoutNoteOrder()->getCloseOrderNoteButton()->click();
    }
}