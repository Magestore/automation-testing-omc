<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/02/2018
 * Time: 08:48
 */

namespace Magento\Webpos\Test\TestCase\Setting\Logout;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSLogoutUnsuccessfullyTest
 * @package Magento\Webpos\Test\TestCase\Setting\Logout
 * SET31
 * Steps
 * 1. Login webpos as a staff
 * 2. Click on Menu icon > Logout
 * 3. Click on [Cancel] button on popup
 * Acceptance Criteria
 * 2. Show confirmation popup including:
 * - Message: ""Are you sure you want to logout?""
 * - Action: Close
 * - Buttons: Cancel, OK
 * 3. Close confirmation popup, logout unsuccessfully
 *
 * SET32
 * Steps
 * 1. Login webpos as a staff
 * 2. Click on Menu icon > Logout
 * 3. Click on [Close] button on popup
 * Acceptance Criteria
 * 3. Close confirmation popup, logout unsuccessfully
 *
 * SET33
 * Steps
 * 1. Login webpos as a staff
 * 2. Click on Menu icon > Logout
 * 3. Click on [OK] button on popup
 * Acceptance Criteria
 * 3.
 * - Close confirmation popup, logout successfully
 * - Back to Login form
 */
class WebPOSLogoutUnsuccessfullyTest extends Injectable
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
     * @param $message
     * @param $testID
     */
    public function test($message, $testID)
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->logout();
        self::assertEquals(
            $message,
            $this->webposIndex->getModal()->getPopupMessage(),
            'On the WebPOS Logout Popup Form. The Popup Message was visible correctly.'
        );
        self::assertTrue(
            $this->webposIndex->getModal()->getOkButton()->isVisible(),
            'On the WebPOS Logout Popup Form. The Button OK was not visible correctly.'
        );
        self::assertTrue(
            $this->webposIndex->getModal()->getCancelButton()->isVisible(),
            'On the WebPOS Logout Popup Form. The Button Cancel was not visible correctly.'
        );
        self::assertTrue(
            $this->webposIndex->getModal()->getCloseButton()->isVisible(),
            'On the WebPOS Logout Popup Form. The Button Close was not visible correctly.'
        );
        if ($testID == 'SET31') {
            $this->webposIndex->getModal()->getCancelButton()->click();
        } elseif ($testID == 'SET32') {
            $this->webposIndex->getModal()->getCloseButton()->click();
        } elseif ($testID == 'SET33') {
            $this->webposIndex->getModal()->getOkButton()->click();
            $this->webposIndex->getLoginForm()->waitForLoginForm();
        }
        self::assertFalse(
            $this->webposIndex->getModal()->getModalPopup()->isVisible(),
            'On the WebPOS Logout Popup Form. The Modal Logout Popup was visible correctly.'
        );
    }
}