<?php
/**
 * Created By thomas
 * Created At 09:40
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
 * Class CreateCustomerAndBillingAddress
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class CreateCustomerAndBillingAddressTest extends Injectable
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
    public function test(Staff $staff, $firstName, $lastName, $email, $group, $company, $phone, $street1, $street2, $city, $zipCode, $country, $province, $vat)
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
        sleep(1);
        if (!empty($email)) {
            $email = str_replace('%isolation%',mt_rand(0,10000),$email);
        }
        $this->webposIndex->getCustomerListContainer()->addValueCustomer($firstName, $lastName, $email, $group);
        sleep(1);
        $this->webposIndex->getCustomerListContainer()->billingAddress()->click();
        sleep(1);
        $addressType = 'billing';
        $this->webposIndex->getCustomerListContainer()->addValueShipping($addressType, $firstName, $lastName, $company, $phone, $street1, $street2, $city, $zipCode, $country, $province, $vat);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveBilling()->click();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveCustomer()->click();
        sleep(3);

        $result['success-message'] = $this->webposIndex->getToaster()->getWarningMessage();
        return ['result' => $result];
    }

}
