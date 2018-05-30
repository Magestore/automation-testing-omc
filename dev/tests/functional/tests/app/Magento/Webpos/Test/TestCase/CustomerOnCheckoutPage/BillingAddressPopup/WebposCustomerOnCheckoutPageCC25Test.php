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
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer\AssertCreateCustomerOnCheckoutPageSuccess;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertBillingAddressOnNewCustomerPopupIsCorrect;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCustomerOnCheckoutPageCC25Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\BillingAddressPopup
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Click on Add new customer icon"
 *
 * Steps:
 * "1. Click on [Create customer] button >Fill out all fields
 * 2. Click on Add Billing address icon > Add an address successfully
 * 3. On [New Customer] popup, click on Delete Billing address icon
 * 4. Click on [Save] button on [New customer] popup"
 *
 * Acceptance:
 * "3. Delete that Billing address from [Billing address] section
 * 5. Save customer successfully
 *
 * "
 *
 */
class WebposCustomerOnCheckoutPageCC25Test extends Injectable
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
     * @var AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess
     */
    protected $assertCreateCustomerOnCheckoutPageSuccess;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect
     * @param AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect,
        AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertBillingAddressOnNewCustomerPopupIsCorrect = $assertBillingAddressOnNewCustomerPopupIsCorrect;
        $this->assertCreateCustomerOnCheckoutPageSuccess = $assertCreateCustomerOnCheckoutPageSuccess;

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

        // fill Billing address info
        $this->webposIndex->getCheckoutAddCustomer()->getAddBillingAddressIcon()->click();
        $this->webposIndex->getCheckoutContainer()->waitForPopupAddBillingVisible();
        $this->webposIndex->getCheckoutAddBillingAddress()->setFieldAddress($address->getData());
        $this->webposIndex->getCheckoutAddBillingAddress()->getSaveButton()->click();
        sleep(1);

        $this->webposIndex->getCheckoutAddCustomer()->getDeleteBillingAddressIcon()->click();
        sleep(1);

        // - [Billing address] section is blank
        $this->assertBillingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, '');
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