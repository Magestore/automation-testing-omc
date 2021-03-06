<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/23/2018
 * Time: 2:36 PM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\BillingAddressPopup;

use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer\AssertCreateCustomerOnCheckoutPageSuccess;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertBillingAddressOnNewCustomerPopupIsCorrect;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertShippingAddressOnNewCustomerPopupIsCorrect;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCustomerOnCheckoutPageCC21Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\ShippingAddressPopup
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Click on Add new customer icon"
 *
 * Steps:
 * "1. Click on [Create customer] button > Fill out all fields
 * 2. Click on Add Billing address icon >Fill out all fields
 * 3. Click on [Save] button
 * 4. Click on [Save] button on [New customer] popup"
 *
 * Acceptance:
 * "3. The created billing address will be shown on [Billing address] section
 * - [Shipping address] section is blank
 * 4. Create customer successfully and show message ""Success: The customer is saved successfully."""
 *
 */
class WebposCustomerOnCheckoutPageCC21Test extends Injectable
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
     * @var AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess
     */
    protected $assertCreateCustomerOnCheckoutPageSuccess;

    /**
     * @var AssertShippingAddressOnNewCustomerPopupIsCorrect $assertShippingAddressOnNewCustomerPopupIsCorrect
     */
    protected $assertShippingAddressOnNewCustomerPopupIsCorrect;

    /**
     * @var AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect
     */
    protected $assertBillingAddressOnNewCustomerPopupIsCorrect;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess
     * @param AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect
     * @param AssertShippingAddressOnNewCustomerPopupIsCorrect $assertShippingAddressOnNewCustomerPopupIsCorrect
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess,
        AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect,
        AssertShippingAddressOnNewCustomerPopupIsCorrect $assertShippingAddressOnNewCustomerPopupIsCorrect
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertCreateCustomerOnCheckoutPageSuccess = $assertCreateCustomerOnCheckoutPageSuccess;
        $this->assertBillingAddressOnNewCustomerPopupIsCorrect = $assertBillingAddressOnNewCustomerPopupIsCorrect;
        $this->assertShippingAddressOnNewCustomerPopupIsCorrect = $assertShippingAddressOnNewCustomerPopupIsCorrect;
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
        $this->objectManager->getInstance()->create(
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
        $this->webposIndex->getCheckoutAddCustomer()->getAddBillingAddressIcon()->click();

        // fill Billing address info
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
        $this->assertBillingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $addressText);

        // - [Shipping address] section is blank
        $this->assertShippingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, '');

        $this->webposIndex->getCheckoutAddCustomer()->getSaveButton()->click();

        // Assert create customer success
        $this->assertCreateCustomerOnCheckoutPageSuccess->processAssert($this->webposIndex, $customer);
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