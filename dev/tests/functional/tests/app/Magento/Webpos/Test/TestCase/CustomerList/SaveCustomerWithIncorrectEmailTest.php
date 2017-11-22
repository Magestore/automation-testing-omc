<?php
/**
 * Created By thomas
 * Created At 08:17
 * Email: thomas@trueplus.vn
 * Last Modified by: ${MODIFIED_BY}
 * Last Modified time: ${MODIFIED_TIME}
 * Links: https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\CustomerList;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class CreateNewCustomerEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class SaveCustomerWithIncorrectEmailTest extends Injectable
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
        sleep(1);
        $this->webposIndex->getCmenu()->customerList();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->clickAddNew()->click();
        if (!empty($email)) {
            $email = str_replace('%isolation%',mt_rand(0,10000),$email);
        }
        $this->webposIndex->getCustomerListContainer()->addValueCustomer($firstName, $lastName, $email, $group);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveCustomer()->click();
        sleep(2);

        $result['incorrect-email'] = $this->webposIndex->getCustomerListContainer()->getEmailError()->getText();
        return ['result' => $result];
    }

}
