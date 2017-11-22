<?php
/**
 * Created By thomas
 * Created At 09:26
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
 * Class SaveBlankShippingEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class SaveBlankShippingEntityTest extends Injectable
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
        sleep(3);
        $this->webposIndex->getCustomerListContainer()->shippingAddress()->click();
        $this->webposIndex->getCustomerListContainer()->saveShipping()->click();
        $result['first-name-shipping'] = $this->webposIndex->getCustomerListContainer()->getFirstNameShippingError()->getText();
        $result['last-name-shipping'] = $this->webposIndex->getCustomerListContainer()->getLastNameShippingError()->getText();
        $result['phone-shipping'] = $this->webposIndex->getCustomerListContainer()->getPhoneError()->getText();
        $result['street-shipping'] = $this->webposIndex->getCustomerListContainer()->getStreetError()->getText();
        $result['city-shipping'] = $this->webposIndex->getCustomerListContainer()->getCityError()->getText();
        $result['zip-code-shipping'] = $this->webposIndex->getCustomerListContainer()->getZipCodeError()->getText();
        $result['country-shipping'] = $this->webposIndex->getCustomerListContainer()->getCountryError()->getText();
        sleep(3);
        return ['result' => $result];
    }

}
