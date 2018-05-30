<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/28/2018
 * Time: 8:28 AM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\BillingAddressPopup;

use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertBillingAddressOnNewCustomerPopupIsCorrect;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCustomerOnCheckoutPageCC24Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\BillingAddressPopup
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Click on Add new customer icon"
 *
 * Steps:
 * "1. Click on [Create customer] button
 * 2. Click on Add Billing address icon > Add an address successfully
 * 3. On [New Customer] popup, click on Edit Billing address icon
 * 4.  Cancel"
 *
 * Acceptance:
 * "4. Close [Edit Billing address], back to [New customer] popup
 * - Billing address is changless"
 *
 */
class WebposCustomerOnCheckoutPageCC24Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect
     */
    protected $assertBillingAddressOnNewCustomerPopupIsCorrect;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertBillingAddressOnNewCustomerPopupIsCorrect = $assertBillingAddressOnNewCustomerPopupIsCorrect;
    }

    /**
     * @param Customer $customer
     * @param Address $address
     */
    public function test(
        Customer $customer,
        Address $address
    )
    {
        $address = $this->prepareAddress($customer, $address);

        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();

        $this->webposIndex->getCheckoutChangeCustomer()->getAddNewCustomerButton()->click();

        // fill customer info
        $this->webposIndex->getCheckoutContainer()->waitForPopupAddCustomerVisible();
        $this->webposIndex->getCheckoutAddCustomer()->setFieldWithoutShippingAndBilling($customer->getData());

        // fill Billing address info
        $this->webposIndex->getCheckoutAddCustomer()->getAddBillingAddressIcon()->click();
        $this->webposIndex->getCheckoutContainer()->waitForPopupAddBillingVisible();
        $this->webposIndex->getCheckoutAddBillingAddress()->setFieldAddress($address->getData());
        $this->webposIndex->getCheckoutAddBillingAddress()->getSaveButton()->click();
        sleep(1);

        // - The created billing address will be shown on [Billing address] section
        $country = [
            'United States' => 'US',
            'United Kingdom' => 'GB',
            'Germany' => 'DE'
        ];
        $addressText = $address->getFirstname() . ' ' . $address->getLastname() . ', '
            . $address->getStreet() . ' ' . $address->getCity() . ', '
            . $country[$address->getCountryId()] . ', '
            . $address->getPostcode() . ', '
            . $address->getTelephone();

        // Assert [Billing address] section is correct
        $this->assertBillingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $addressText);

        $this->webposIndex->getCheckoutAddCustomer()->getEditBillingAddressIcon()->click();
        sleep(1);
        $this->webposIndex->getCheckoutAddBillingAddress()->getCancelButton()->click();

        // Assert [Billing address] is changeless
        $this->assertBillingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $addressText);
    }

    /**
     * @param Customer $customer
     * @param Address $address
     * @return Address
     */
    protected function prepareAddress(Customer $customer, Address $address)
    {
        $addressData = $address->getData();
        $addressData['firstname'] = $customer->getFirstname();
        $addressData['lastname'] = $customer->getLastname();
        $addressData['email'] = $customer->getEmail();
        return $this->fixtureFactory->createByCode('address', ['data' => $addressData]);
    }
}