<?php
/**
 * Created By thomas
 * Created At 10:20
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
 * Class CheckValueCustomerBillingEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class CheckValueCustomerBillingEntityTest extends Injectable
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
        sleep(1);
        $this->webposIndex->getCmenu()->customerList();
        sleep(1);
        $this->webposIndex->getCustomerListContainer()->clickAddNew()->click();
        sleep(2);
        if (!empty($email)) {
            $email = str_replace('%isolation%',mt_rand(0,10000),$email);
        }
        $this->webposIndex->getCustomerListContainer()->addValueCustomer($firstName, $lastName, $email, $group);
        $this->webposIndex->getCustomerListContainer()->billingAddress()->click();
        $addressType = 'billing';
        $this->webposIndex->getCustomerListContainer()->addValueShipping($addressType, $firstName, $lastName, $company, $phone, $street1, $street2, $city, $zipCode, $country, $province, $vat);
        sleep(3);
        $this->webposIndex->getCustomerListContainer()->saveBilling()->click();
        sleep(2);
        //click edit address shipping
        $this->webposIndex->getCustomerListContainer()->editBilling()->click();
        //return value of the shipping address
        $addressType = 'billing';
        $result['first-name-address'] = $this->webposIndex->getCustomerListContainer()->getValueFirstNameAddress($addressType)->getValue();
        $result['last-name-address'] = $this->webposIndex->getCustomerListContainer()->getValueLastNameAddress($addressType)->getValue();
        $result['company-name-address'] = $this->webposIndex->getCustomerListContainer()->getValueCompanyAddress($addressType)->getValue();
        $result['phone-address'] = $this->webposIndex->getCustomerListContainer()->getValuePhoneAddress($addressType)->getValue();
        $result['street-first-address'] = $this->webposIndex->getCustomerListContainer()->getValueStreetFirstAddress($addressType)->getValue();
        $result['street-second-address'] = $this->webposIndex->getCustomerListContainer()->getValueStreetSecondAddress($addressType)->getValue();
        $result['city-address'] = $this->webposIndex->getCustomerListContainer()->getValueCityAddress($addressType)->getValue();
        $result['zip-code-address'] = $this->webposIndex->getCustomerListContainer()->getValueZipCodeAddress($addressType)->getValue();
        $result['country-address'] = $this->webposIndex->getCustomerListContainer()->getValueCountryAddress($addressType)->getText();
        $result['province-address'] = $this->webposIndex->getCustomerListContainer()->getValueProvinceAddress($addressType)->getValue();
        $result['vat-address'] = $this->webposIndex->getCustomerListContainer()->getValueVATAddress($addressType)->getValue();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveBilling()->click();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveCustomer()->click();
        sleep(5);

        $result['success-message'] = $this->webposIndex->getToaster()->getWarningMessage();
        return ['result' => $result];
    }
}
