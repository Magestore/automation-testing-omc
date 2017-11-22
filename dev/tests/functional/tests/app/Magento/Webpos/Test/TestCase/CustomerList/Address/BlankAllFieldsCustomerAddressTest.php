<?php
/**
 * Created by: thomas
 * Date: 11/10/2017
 * Time: 16:19
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\CustomerList\Address;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class BlankAllFieldsCustomerAddressTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class BlankAllFieldsCustomerAddressTest extends Injectable
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
    public function test(Staff $staff, $emailInitial, $company, $phone, $street1, $street2, $city, $zipCode, $country, $province, $vat)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCmenu()->customerList();
        sleep(1);
        $this->webposIndex->getCustomerListContainer()->searchCustomer()->setValue($emailInitial);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->clickAddAddress()->click();
        $this->webposIndex->getCustomerListContainer()->addAddressCustomer($company, $phone, $street1, $street2, $city, $zipCode, $country, $province, $vat);
        sleep(3);
        $result = [];
        if ($this->webposIndex->getToaster()->getWarningMessage()->isVisible()) {
            $result['success'] = $this->webposIndex->getToaster()->getWarningMessage();
        } else {
            $result['customer-phone-error'] = $this->webposIndex->getCustomerListContainer()->getCustomerPhoneError()->getText();
            $result['customer-street-error'] = $this->webposIndex->getCustomerListContainer()->getCustomerStreetError()->getText();
            $result['customer-city-error'] = $this->webposIndex->getCustomerListContainer()->getCustomerCityError()->getText();
            $result['customer-zipcode-error'] = $this->webposIndex->getCustomerListContainer()->getCustomerZipcodeError()->getText();
            $result['customer-country-error'] = $this->webposIndex->getCustomerListContainer()->getCustomerCountryError()->getText();
        }
        return ['result' => $result];
    }
}
