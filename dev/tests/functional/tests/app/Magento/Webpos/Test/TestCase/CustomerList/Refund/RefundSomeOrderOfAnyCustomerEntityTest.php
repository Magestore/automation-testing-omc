<?php
/**
 * Created by: thomas
 * Date: 12/10/2017
 * Time: 14:46
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\CustomerList\Refund;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class RefundSomeOrderOfAnyCustomerEntityTest extends Injectable
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

        // Click Menu Button to see menu dropdown
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
        //define array variable for assertion
        $result = [];
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
        $this->webposIndex->getCmenu()->ordersHistory();
        sleep(1);
        $value = str_replace('#', '', $result['order-id']);
        $this->webposIndex->getOrdersHistory()->search($value);
        sleep(1);
        $this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
        sleep(2);
        $this->webposIndex->getOrdersHistory()->getAction('Refund')->click();
        sleep(2);
        foreach ($products as $name) {
            $this->webposIndex->getOrdersHistory()->getRefundItemReturnToStockCheckbox($name)->click();
            sleep(2);
        }
        $this->webposIndex->getOrdersHistory()->submitRefund()->click();
        sleep(2);
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);
        $this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
        sleep(2);
        self::assertFalse(
            $this->webposIndex->getOrdersHistory()->getAction('Refund')->isVisible(),
            'Refund success'
        );
        //A creditmemo has been created!
        $result['refund-order'] = $this->webposIndex->getToaster()->getWarningMessage();
        return ['result' => $result];
    }

}
