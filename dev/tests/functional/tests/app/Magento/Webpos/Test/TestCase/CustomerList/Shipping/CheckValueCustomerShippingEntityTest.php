<?php
/**
 * Created By thomas
 * Created At 11:00
 * Email: thomas@trueplus.vn
 * Last Modified by: ${MODIFIED_BY}
 * Last Modified time: ${MODIFIED_TIME}
 * Links: https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\CustomerList\Shipping;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class CheckValueCustomerShippingEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class CheckValueCustomerShippingEntityTest extends Injectable
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
        if (!empty($email)) {
            $email = str_replace('%isolation%',mt_rand(0,10000),$email);
        }
        $this->webposIndex->getCustomerListContainer()->addValueCustomer($firstName, $lastName, $email, $group);
        $this->webposIndex->getCustomerListContainer()->shippingAddress()->click();
        $addressType = 'shipping';
        $this->webposIndex->getCustomerListContainer()->addValueShipping($addressType, $firstName, $lastName, $company, $phone, $street1, $street2, $city, $zipCode, $country, $province, $vat);
        sleep(3);
        $this->webposIndex->getCustomerListContainer()->checkSameShippingAndBillingAddress();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveShipping()->click();
        sleep(2);
        //click edit address shipping
        $this->webposIndex->getCustomerListContainer()->editShipping()->click();
        //return value of the shipping address
        $result['first-name-address'] = $this->webposIndex->getCustomerListContainer()->getValueFirstNameAddress()->getValue();
        $result['last-name-address'] = $this->webposIndex->getCustomerListContainer()->getValueLastNameAddress()->getValue();
        $result['company-name-address'] = $this->webposIndex->getCustomerListContainer()->getValueCompanyAddress()->getValue();
        $result['phone-address'] = $this->webposIndex->getCustomerListContainer()->getValuePhoneAddress()->getValue();
        $result['street-first-address'] = $this->webposIndex->getCustomerListContainer()->getValueStreetFirstAddress()->getValue();
        $result['street-second-address'] = $this->webposIndex->getCustomerListContainer()->getValueStreetSecondAddress()->getValue();
        $result['city-address'] = $this->webposIndex->getCustomerListContainer()->getValueCityAddress()->getValue();
        $result['zip-code-address'] = $this->webposIndex->getCustomerListContainer()->getValueZipCodeAddress()->getValue();
        $result['country-address'] = $this->webposIndex->getCustomerListContainer()->getValueCountryAddress()->getText();
        $result['province-address'] = $this->webposIndex->getCustomerListContainer()->getValueProvinceAddress()->getValue();
        $result['vat-address'] = $this->webposIndex->getCustomerListContainer()->getValueVATAddress()->getValue();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveShipping()->click();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveCustomer()->click();
        sleep(5);

        $result['success-message'] = $this->webposIndex->getToaster()->getWarningMessage();
        return ['result' => $result];
    }
}
