<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/11/2017
 * Time: 09:24
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckout;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class PopupChangeCustomerEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckout
 */
class PopupChangeCustomerCOC01EntityTest extends Injectable
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

        self::assertTrue(
            $this->webposIndex->getPopupChangeCustomer()->getCreateCustomer()->isVisible(),
            'Button Create Customer In Customer On Checkout Page Is not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getPopupChangeCustomer()->getUseGuest()->isVisible(),
            'Button Use Guest In Customer On Checkout Page Is not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getPopupChangeCustomer()->getSearchCustomer()->isVisible(),
            'Input Search Customer In Customer On Checkout Page Is not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getPopupChangeCustomer()->getItemCustomerList()->isVisible(),
            'List Item Of Customer In Customer On Checkout Page Is not visible.'
        );
    }
}