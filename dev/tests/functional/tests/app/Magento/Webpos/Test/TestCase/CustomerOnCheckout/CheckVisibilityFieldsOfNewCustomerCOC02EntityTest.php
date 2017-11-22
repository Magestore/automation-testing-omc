<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/11/2017
 * Time: 10:46
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckout;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class CheckVisibilityFieldsOfNewCustomerCOC02EntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckout
 */
class CheckVisibilityFieldsOfNewCustomerCOC02EntityTest extends Injectable
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
        sleep(1);
        $this->webposIndex->getPopupChangeCustomer()->getCreateCustomer()->click();

        self::assertTrue(
            $this->webposIndex->getAddCustomerOnCheckout()->getCustomerFirstName()->isVisible(),
            'Customer First Name Input In Customer On Checkout Page Is not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getAddCustomerOnCheckout()->getCustomerLastName()->isVisible(),
            'Customer Last Name InputIn Customer On Checkout Page Is not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getAddCustomerOnCheckout()->getCustomerEmail()->isVisible(),
            'Customer Email Input In Customer On Checkout Page Is not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getAddCustomerOnCheckout()->getCustomerGroup()->isVisible(),
            'Customer Group Select In Customer On Checkout Page Is not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getAddCustomerOnCheckout()->getCustomerSwitchBox()->isVisible(),
            'Customer Switch Box In Customer On Checkout Page Is not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getAddCustomerOnCheckout()->getAddShippingAddress()->isVisible(),
            'Customer Add Shipping Address Create Customer In Customer On Checkout Page Is not visible.'
        );
        self::assertTrue(
            $this->webposIndex->getAddCustomerOnCheckout()->getAddBillingAddress()->isVisible(),
            'Customer Add Billing Address In Customer On Checkout Page Is not visible.'
        );
    }
}