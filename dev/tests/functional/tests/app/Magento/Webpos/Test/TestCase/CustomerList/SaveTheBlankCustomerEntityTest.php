<?php
/**
 * Created By thomas
 * Created At 07:51
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
class SaveTheBlankCustomerEntityTest extends Injectable
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
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCmenu()->customerList();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->clickAddNew()->click();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveCustomer()->click();
        sleep(3);
        //return error
        $result['first-name-error'] = $this->webposIndex->getCustomerListContainer()->getFirstNameError()->getText();
        $result['last-name-error'] = $this->webposIndex->getCustomerListContainer()->getLastNameError()->getText();
        $result['email-error'] = $this->webposIndex->getCustomerListContainer()->getEmailError()->getText();
        $result['customer-group-error'] = $this->webposIndex->getCustomerListContainer()->getGroupCustomerError()->getText();
        return ['result' => $result];

    }

}
