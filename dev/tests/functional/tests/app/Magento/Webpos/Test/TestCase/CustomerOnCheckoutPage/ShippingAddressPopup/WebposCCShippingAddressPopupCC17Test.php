<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/02/2018
 * Time: 11:15
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\ShippingAddressPopup;

use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer\AssertCreateCustomerOnCheckoutPageSuccess;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertBillingAddressOnEditCustomerPopupIsCorrect;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertBillingAddressOnNewCustomerPopupIsCorrect;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertShippingAddressOnEditCustomerPopupIsCorrect;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertShippingAddressOnNewCustomerPopupIsCorrect;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposCCShippingAddressPopupCC17Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\ShippingAddressPopup
 */
class WebposCCShippingAddressPopupCC17Test extends Injectable
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
     * @var AssertShippingAddressOnNewCustomerPopupIsCorrect $assertShippingAddressOnNewCustomerPopupIsCorrect
     */
    protected $assertShippingAddressOnNewCustomerPopupIsCorrect;

    /**
     * @var AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect
     */
    protected $assertBillingAddressOnNewCustomerPopupIsCorrect;

    /**
     * @var AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess
     */
    protected $assertCreateCustomerOnCheckoutPageSuccess;

    /**
     * @var AssertShippingAddressOnEditCustomerPopupIsCorrect $assertShippingAddressOnEditCustomerPopupIsCorrect
     */
    protected $assertShippingAddressOnEditCustomerPopupIsCorrect;

    /**
     * @var AssertBillingAddressOnEditCustomerPopupIsCorrect $assertBillingAddressOnEditCustomerPopupIsCorrect
     */
    protected $assertBillingAddressOnEditCustomerPopupIsCorrect;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertShippingAddressOnNewCustomerPopupIsCorrect $assertShippingAddressOnNewCustomerPopupIsCorrect
     * @param AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect
     * @param AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess
     * @param AssertShippingAddressOnEditCustomerPopupIsCorrect $assertShippingAddressOnEditCustomerPopupIsCorrect
     * @param AssertBillingAddressOnEditCustomerPopupIsCorrect $assertBillingAddressOnEditCustomerPopupIsCorrect
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertShippingAddressOnNewCustomerPopupIsCorrect $assertShippingAddressOnNewCustomerPopupIsCorrect,
        AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect,
        AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess,
        AssertShippingAddressOnEditCustomerPopupIsCorrect $assertShippingAddressOnEditCustomerPopupIsCorrect,
        AssertBillingAddressOnEditCustomerPopupIsCorrect $assertBillingAddressOnEditCustomerPopupIsCorrect
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertShippingAddressOnNewCustomerPopupIsCorrect = $assertShippingAddressOnNewCustomerPopupIsCorrect;
        $this->assertBillingAddressOnNewCustomerPopupIsCorrect = $assertBillingAddressOnNewCustomerPopupIsCorrect;
        $this->assertCreateCustomerOnCheckoutPageSuccess = $assertCreateCustomerOnCheckoutPageSuccess;
        $this->assertShippingAddressOnEditCustomerPopupIsCorrect = $assertShippingAddressOnEditCustomerPopupIsCorrect;
        $this->assertBillingAddressOnEditCustomerPopupIsCorrect = $assertBillingAddressOnEditCustomerPopupIsCorrect;
    }

    /**
     * @param Customer $customer
     * @param Address $address
     * @param string $sameShippingAndBillingAddress
     */
    public function test(
        Customer $customer,
        Address $address,
        $sameShippingAndBillingAddress = 'Yes'
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
        $this->webposIndex->getCheckoutAddCustomer()->getAddShippingAddressIcon()->click();
        //fill shipping address info
        $this->webposIndex->getCheckoutContainer()->waitForPopupAddShippingVisible();
        $this->webposIndex->getCheckoutAddShippingAddress()->setFieldAddress($address->getData());

        $this->webposIndex->getCheckoutAddShippingAddress()->getSameBillingShippingCheckbox()->setValue($sameShippingAndBillingAddress);

        $this->webposIndex->getCheckoutAddShippingAddress()->getSaveButton()->click();
        sleep(1);
        // - The created shipping address will be shown on [Shipping address] section
        $country= [
            'United States' => 'US',
            'United Kingdom' => 'GB',
            'Germany' => 'DE'
        ];
        $addressText = $address->getFirstname().' '.$address->getLastname().', '
            .$address->getStreet().' '.$address->getCity().', '
            .$country[$address->getCountryId()].', '
            .$address->getPostcode().', '
            .$address->getTelephone();
        $this->assertShippingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $addressText);
        // Assert [Billing address] section is correct
        $this->assertBillingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $addressText);
        // Delete Shipping address
        $this->webposIndex->getCheckoutAddCustomer()->getDeleteShippingAddressIcon()->click();
        sleep(1);
        // Assert ship address is blank
        $this->assertShippingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, '');
        // Assert billing address is changeless
        $this->assertBillingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $addressText);

        $this->webposIndex->getCheckoutAddCustomer()->getSaveButton()->click();

        $this->assertCreateCustomerOnCheckoutPageSuccess->processAssert($this->webposIndex, $customer);

        $this->webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->click();
        sleep(1);
        $fullname = $address->getFirstname().' '.$address->getLastname();
        $addressText = $address->getStreet().' , '
            .$address->getCity().' , '
            .$address->getRegion().' , '
            .$country[$address->getCountryId()].' '
            .$address->getPostcode();
        $phone = $address->getTelephone();
        // Assert ship address is blank
        $this->assertShippingAddressOnEditCustomerPopupIsCorrect->processAssert($this->webposIndex, $fullname, '', $phone);
        // Assert billing address is correct
        $this->assertBillingAddressOnEditCustomerPopupIsCorrect->processAssert($this->webposIndex, $fullname, $addressText, $phone);

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