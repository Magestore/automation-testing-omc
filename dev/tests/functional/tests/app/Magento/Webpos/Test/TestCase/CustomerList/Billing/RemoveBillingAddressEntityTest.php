<?php
/**
 * Created By thomas
 * Created At 10:40
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
 * Class RemoveBillingAddressEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class RemoveBillingAddressEntityTest extends Injectable
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
        sleep(2);
        if (!empty($email)) {
            $email = str_replace('%isolation%',mt_rand(0,10000),$email);
        }
        $this->webposIndex->getCustomerListContainer()->addValueCustomer($firstName, $lastName, $email, $group);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->billingAddress()->click();
        $addressType = 'billing';
        $this->webposIndex->getCustomerListContainer()->addValueShipping($addressType, $firstName, $lastName, $company, $phone, $street1, $street2, $city, $zipCode, $country, $province, $vat);
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveBilling()->click();
        sleep(1);
        $this->webposIndex->getCustomerListContainer()->removeBilling()->click();
        sleep(1);
        //click edit address billing
        if (!($this->webposIndex->getCustomerListContainer()->billingAddress()->click())) {
            $this->webposIndex->getCustomerListContainer()->cancelBilling()->click();
            $this->webposIndex->getCustomerListContainer()->saveCustomer()->click();
            sleep(5);
            $result['success-message'] = $this->webposIndex->getToaster()->getWarningMessage();
            return ['result' => $result];
        } else {
            self::assertFalse(
                $this->webposIndex->getCustomerListContainer()->editBilling()->isVisible(),
                'The edit billing button is not empty'
            );
        }
    }
}
