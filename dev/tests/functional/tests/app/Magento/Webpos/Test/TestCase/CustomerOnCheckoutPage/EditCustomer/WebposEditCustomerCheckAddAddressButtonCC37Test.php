<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/26/2018
 * Time: 3:51 PM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer;

use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposEditCustomerCheckAddAddressButtonCC37Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Click on Add new customer icon
 * 3. Select a customer in list"
 *
 * Steps:
 * "1. Click to edit the selected customer
 * 2. Click on [Add address] button
 * 3.  Fill out all fields > Save"
 *
 * Acceptance:
 * 3. Close popup and the created address will be shown in Shipping/Billing address list
 *
 */
class WebposEditCustomerCheckAddAddressButtonCC37Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(WebposIndex $webposIndex, FixtureFactory $factory)
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $factory;
    }

    public function test(Address $address)
    {
        // Create Customer
        $customer = $this->fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Select an existing customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();

        $this->webposIndex->getCheckoutChangeCustomer()->search($customer->getEmail());
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-change-customer"]');
        sleep(1);
        $this->webposIndex->getCheckoutCartHeader()->getIconEditCustomer()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-edit-customer"]');
        $this->webposIndex->getCheckoutEditCustomer()->getAddAddressButton()->click();
        sleep(1);
        $this->assertTrue(
            $this->webposIndex->getCheckoutEditAddress()->isVisible(),
            'Add address popup is not visible.'
        );
        //fill address data
        $this->webposIndex->getCheckoutEditAddress()->setFiledAdress($address->getData());
        $this->webposIndex->getCheckoutEditAddress()->getSaveButton()->click();
        $this->webposIndex->getCheckoutEditAddress()->waitForElementNotVisible('[id="customer-overlay"]');
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getCheckoutEditAddress()->isVisible(),
            'Add address popup is not hidden.'
        );
        $this->assertTrue(
            $this->webposIndex->getCheckoutEditCustomer()->getShippingAddressItem('John Doe, Culver City, US, California, 555-55-555-55')->isVisible(),
            'New address is not visible in shipping address list.'
        );
        $this->assertTrue(
            $this->webposIndex->getCheckoutEditCustomer()->getBillingAddressItem('John Doe, Culver City, US, California, 555-55-555-55')->isVisible(),
            'New address is not visible in billing address list.'
        );

        return ['customer' => $customer];
    }
}