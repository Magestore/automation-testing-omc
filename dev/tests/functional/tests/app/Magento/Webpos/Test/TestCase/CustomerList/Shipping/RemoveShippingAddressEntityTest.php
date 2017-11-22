<?php
/**
 * Created By thomas
 * Created At 10:40
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
 * Class RemoveShippingAddressEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class RemoveShippingAddressEntityTest extends Injectable
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
        sleep(5);
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
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->checkSameShippingAndBillingAddress();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->saveShipping()->click();
        sleep(2);
        $this->webposIndex->getCustomerListContainer()->removeShipping()->click();
        //click edit address shipping
        if (!($this->webposIndex->getCustomerListContainer()->shippingAddress()->click())) {
            $this->webposIndex->getCustomerListContainer()->cancelShipping()->click();
            $this->webposIndex->getCustomerListContainer()->saveCustomer()->click();
            sleep(5);
            $result['success-message'] = $this->webposIndex->getToaster()->getWarningMessage();
            return ['result' => $result];
        } else {
            self::assertFalse(
                $this->webposIndex->getCustomerListContainer()->editShipping()->isVisible(),
                'The edit shipping button is not empty'
            );
        }
    }
}
