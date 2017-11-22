<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-20 13:58:52
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   Thomas
 * @Last Modified time: 2017-11-02 15:59:09
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Checkout;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class OrderSetCustomeSaleEntityTest extends Injectable
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
    public function test(Staff $staff, $productDiscount, $products, $email)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);

        // Set custome sale
        foreach ($productDiscount as $values) {
            $values = explode('-',$values);
            $productName = $values[0];
            $productPrice = $values[1];
            $this->webposIndex->getCheckoutPage()->setCustomSale($productName, $productPrice);
        }
        $this->webposIndex->getCheckoutPage()->addSomeProduct($products, $email, $setDiscount='1');
    }
}
