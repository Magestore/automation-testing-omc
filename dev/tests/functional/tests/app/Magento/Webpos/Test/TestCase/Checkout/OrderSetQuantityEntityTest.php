<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-20 13:45:08
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   Thomas
 * @Last Modified time: 2017-11-02 15:59:11
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Checkout;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class OrderSetQuantityEntityTest extends Injectable
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
    public function test(Staff $staff, $products, $email)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);

        // Add product to cart and set quantity for product
        $this->webposIndex->getCheckoutPage()->addSomeProduct($products, $email, $setDiscount='', $paymentMethod='multi');
    }
}
