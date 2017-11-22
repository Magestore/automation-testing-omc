<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/11/2017
 * Time: 13:19
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckout;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class CheckVisibilityFieldsOfNewCustomerCOC02EntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckout
 */
class HidePopUpCustomerOnCheckoutCOC03EntityTest extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * Inject Webpos Login pages.
     *
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
     * Login Webpos group test.
     *
     * @param Staff $staff
     * @return void
     */

    public function test(Staff $staff)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {
        }
        sleep(2);

        $this->webposIndex->getWebposCart()->getIconChangeCustomer()->click();
        $this->webposIndex->getPopupChangeCustomer()->getUseGuest()->click();

        self::assertFalse(
            $this->webposIndex->getCheckoutPage()->getPopUpChangeCustomer()->isVisible(),
            'After click to icon Customer on the top right, Customer On Checkout PopUp was Closed.'
        );
    }
}