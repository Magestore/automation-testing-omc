<?php
/**
 * Created By thomas
 * Created At 09:11
 * Email: thomas@trueplus.vn
 * Last Modified by: ${MODIFIED_BY}
 * Last Modified time: ${MODIFIED_TIME}
 * Links: https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\CustomerList\Billing;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class SaveBlankBillingAddressEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class SaveBlankBillingAddressEntityTest extends Injectable
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
        $this->webposIndex->getCustomerListContainer()->billingAddress()->click();
        $this->webposIndex->getCustomerListContainer()->saveBilling()->click();
        $result['first-name-billing'] = $this->webposIndex->getCustomerListContainer()->getFirstNameBillingError()->getText();
        $result['last-name-billing'] = $this->webposIndex->getCustomerListContainer()->getLastNameBillingError()->getText();
        $result['phone-billing'] = $this->webposIndex->getCustomerListContainer()->getPhoneBillingError()->getText();
        $result['street-billing'] = $this->webposIndex->getCustomerListContainer()->getStreetBillingError()->getText();
        $result['city-billing'] = $this->webposIndex->getCustomerListContainer()->getCityBillingError()->getText();
        $result['zip-code-billing'] = $this->webposIndex->getCustomerListContainer()->getZipCodeBillingError()->getText();
        $result['country-billing'] = $this->webposIndex->getCustomerListContainer()->getCountryBillingError()->getText();
        sleep(3);
        return ['result' => $result];
    }

}
