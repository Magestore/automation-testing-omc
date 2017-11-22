<?php
/**
 * Created by: thomas
 * Date: 11/10/2017
 * Time: 14:40
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\CustomerList;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class EditCustomerBlankAllFieldsTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class EditCustomerBlankAllFieldsTest extends Injectable
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
    public function test(Staff $staff, $emailInitial, $firstName, $lastName, $email, $group)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCmenu()->customerList();
        sleep(1);
        $this->webposIndex->getCustomerListContainer()->searchCustomer()->setValue($emailInitial);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->clickEditCustomerButton()->click();
        sleep(1);
        $this->webposIndex->getCustomerListContainer()->editFirstName()->setValue($firstName);
        sleep(1);
        $this->webposIndex->getCustomerListContainer()->editLastName()->setValue($lastName);
        if (!empty($email)) {
            $email = str_replace('%isolation%',mt_rand(0,10000),$email);
        }
        $this->webposIndex->getCustomerListContainer()->editEmail()->setValue($email);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->editGroup($group);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveCustomerEditted()->click();
        sleep(2);
        $result = [];
        if ($this->webposIndex->getToaster()->getWarningMessage()->isVisible()) {
            $result['success'] = $this->webposIndex->getToaster()->getWarningMessage();
        } else {
            $result['first-name'] = $this->webposIndex->getCustomerListContainer()->getInforFirstNameError()->getText();
            $result['last-name'] = $this->webposIndex->getCustomerListContainer()->getInforLastNameError()->getText();
            $result['email'] = $this->webposIndex->getCustomerListContainer()->getInforEmailError()->getText();
            $result['customer-group'] = $this->webposIndex->getCustomerListContainer()->getInforGroupCustomerError()->getText();
        }
        sleep(3);
        return ['result' => $result];
    }
}
