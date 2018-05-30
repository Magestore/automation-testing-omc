<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/12/2017
 * Time: 17:45
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPageActionMenu;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposClickSaveAndClosePopupOrderNoteTest
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\CategoryRepository\CartPageActionMenu
 *
 * Precondition:
 * 1. Login Webpos as a staff
 *
 * Steps:
 * "1. Click on action menu ""..."" on the top-right of the screen
 * 2. Click on ""Add order note""
 * 3. Click on ""Save"" button"
 *
 * Acceptance:
 * 1. Close "Order comment" popup
 *
 */
class WebposClickSaveAndClosePopupOrderNoteTest extends Injectable
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

        $this->webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
        $this->webposIndex->getCheckoutFormAddNote()->getAddOrderNote()->click();
        $this->webposIndex->getCheckoutNoteOrder()->getTextArea()->setValue('');
        $this->webposIndex->getCheckoutNoteOrder()->getSaveOrderNoteButon()->click();
    }
}