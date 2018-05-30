<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/02/2018
 * Time: 10:07
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\ShippingAddressPopup;

use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer\AssertCreateCustomerOnCheckoutPageSuccess;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertCreatedAddressIsShownOnEditCustomerPopup;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertCreatedAddressIsShownOnNewCustomerPopup;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCCShippingAddressPopupCC12Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\ShippingAddressPopup
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Click on Add new customer icon"
 *
 * Steps:
 * "1. Click on [Create customer] button
 * 2. Input valid values into all fields of New customer popup
 * 3. Click on Add shipping address icon
 * 4. Input into all fields on Add shipping address popup
 * 5. Click on [Save] button
 * 6. Click on [Save] button
 * 7. Click on the Customer name on cart page"
 *
 * Acceptance:
 * "3. First name and last name will be filled automatically into corresponding fields on Add shipping address popup.
 * 5.
 * - Close Add shipping address popup, back to New customer popup.
 * - The created address will be shown on [Shipping address] and [Billing address] section
 * 6. Create customer successfully and show message ""Success: The customer is saved successfully.""
 * 7. The created address will be shown on Shipping Address and Billing Address"
 *
 */
class WebposCCShippingAddressPopupCC12Test extends Injectable
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
     * @var AssertCreatedAddressIsShownOnNewCustomerPopup $assertCreatedAddressIsShownOnNewCustomerPopup
     */
    protected $assertCreatedAddressIsShownOnNewCustomerPopup;

    /**
     * @var AssertCreatedAddressIsShownOnEditCustomerPopup $assertCreatedAddressIsShownOnEditCustomerPopup
     */
    protected $assertCreatedAddressIsShownOnEditCustomerPopup;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess
     * @param AssertCreatedAddressIsShownOnNewCustomerPopup $assertCreatedAddressIsShownOnNewCustomerPopup
     * @param AssertCreatedAddressIsShownOnEditCustomerPopup $assertCreatedAddressIsShownOnEditCustomerPopup
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess,
        AssertCreatedAddressIsShownOnNewCustomerPopup $assertCreatedAddressIsShownOnNewCustomerPopup,
        AssertCreatedAddressIsShownOnEditCustomerPopup $assertCreatedAddressIsShownOnEditCustomerPopup
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertCreateCustomerOnCheckoutPageSuccess = $assertCreateCustomerOnCheckoutPageSuccess;
        $this->assertCreatedAddressIsShownOnNewCustomerPopup = $assertCreatedAddressIsShownOnNewCustomerPopup;
        $this->assertCreatedAddressIsShownOnEditCustomerPopup = $assertCreatedAddressIsShownOnEditCustomerPopup;
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

        $this->webposIndex->getCheckoutAddCustomer()->getAddShippingAddressIcon()->click();
        sleep(1);
        // Assert first name and last name is auto filled
        self::assertEquals(
            $customer->getFirstname(),
            $this->webposIndex->getCheckoutAddShippingAddress()->getFirstNameInput()->getValue(),
            "Customer on checkout page - shipping address popup - First name feild is not filled automatically"
        );
        self::assertEquals(
            $customer->getLastname(),
            $this->webposIndex->getCheckoutAddShippingAddress()->getLastNameInput()->getValue(),
            "Customer on checkout page - shipping address popup - First name feild is not filled automatically"
        );
        //fill shipping address info
        $this->webposIndex->getCheckoutContainer()->waitForPopupAddShippingVisible();
        $this->webposIndex->getCheckoutAddShippingAddress()->setFieldAddress($address->getData());

        $this->webposIndex->getCheckoutAddShippingAddress()->getSaveButton()->click();
        sleep(1);
        // Assert the created address will be shown on [Shipping address] and [Billing address] section
        $this->assertCreatedAddressIsShownOnNewCustomerPopup->processAssert($this->webposIndex, $address);

        $this->webposIndex->getCheckoutAddCustomer()->getSaveButton()->click();
        // Assert create customer success
        $this->assertCreateCustomerOnCheckoutPageSuccess->processAssert($this->webposIndex, $customer);
        $this->webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->click();
        // Assert the created address will be shown on edit customer popup
        $this->assertCreatedAddressIsShownOnEditCustomerPopup->processAssert($this->webposIndex, $address);
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