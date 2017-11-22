<?php
/**
 * Created by: thomas
 * Date: 12/10/2017
 * Time: 09:35
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\CustomerList\Checkout;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class UseCustomerListToCheckoutEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class UseCustomerListToCheckoutEntityTest extends Injectable
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
    public function test(Staff $staff, $emailInitial, $products)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {
        }
        sleep(2);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCmenu()->customerList();
        sleep(1);
        $this->webposIndex->getCustomerListContainer()->searchCustomer()->setValue($emailInitial);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->useToCheckout()->click();
        sleep(2);
        $this->webposIndex->getCheckoutPage()->clickFirstProduct();
        foreach ($products as $product) {
            $this->webposIndex->getCheckoutPage()->search($product);
        }
        sleep(2);
        $this->webposIndex->getCheckoutPage()->clickCheckoutButton();
        sleep(1);
        $this->webposIndex->getCheckoutPage()->selectPayment();
        sleep(1);
        $this->webposIndex->getCheckoutPage()->clickPlaceOrder();
        $result['notify-order-text'] = $this->webposIndex->getToaster()->getWarningMessage();
        sleep(1);
        $email = $this->webposIndex->getCheckoutPage()->getCustomerEmail();
        $this->webposIndex->getCheckoutPage()->clickSendEmail();
        $result['send-email-success'] = $this->webposIndex->getToaster()->getWarningMessage();
        sleep(1);
        $result['order-id'] = $this->webposIndex->getCheckoutPage()->getOrderId();
        sleep(1);
        $this->webposIndex->getCheckoutPage()->clickNewOrderButton();
        sleep(1);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCMenu()->ordersHistory();
        sleep(1);
        $this->webposIndex->getOrdersHistory()->search($email);
        sleep(3);
        return ['result' => $result];
    }

}
