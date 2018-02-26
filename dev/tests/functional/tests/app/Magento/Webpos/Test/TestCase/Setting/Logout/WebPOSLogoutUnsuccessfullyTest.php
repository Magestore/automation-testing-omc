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
 */
class WebPOSLogoutUnsuccessfullyTest extends Injectable
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

    public function test($message, $testID)
    {
        // Login webpos
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