<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-28 08:33:01
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   Thomas
 * @Last Modified time: 2017-11-02 14:05:05
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\CustomerList;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class CreateNewCustomerSubcibeOnEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class CreateNewCustomerSubcibeOnEntityTest extends Injectable
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
    public function test(Staff $staff, $firstName, $lastName, $email, $group)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(2);
        $this->webposIndex->getCmenu()->customerList();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->clickAddNew()->click();
        if (!empty($email)) {
            $email = str_replace('%isolation%',mt_rand(0,10000),$email);
        }
        $this->webposIndex->getCustomerListContainer()->addValueCustomer($firstName, $lastName, $email, $group);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->subcribeNewsletter()->click();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveCustomer()->click();
        sleep(3);

        $result['success-message'] = $this->webposIndex->getToaster()->getWarningMessage();
        return ['result' => $result];
    }
}
