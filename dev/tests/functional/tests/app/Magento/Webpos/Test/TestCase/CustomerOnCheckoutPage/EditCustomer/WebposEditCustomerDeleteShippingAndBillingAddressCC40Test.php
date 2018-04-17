<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/27/2018
 * Time: 8:59 AM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer;

use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposEditCustomerDeleteShippingAndBillingAddressCC40Test extends Injectable
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

    public function test()
    {
        // Create Customer
        $customer = $this->fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI_ship_CA_bill']);
        $customer->persist();
        // Login webpos
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
        //Edit customer
        $this->webposIndex->getCheckoutCartHeader()->getIconEditCustomer()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-edit-customer"]');
        //Delete shipping address
        $this->webposIndex->getCheckoutEditCustomer()->getDeleteShippingAddressIcon()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('.modal-popup');
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.modal-popup');
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getCheckoutEditCustomer()->getShippingAddressItem('John Doe, Calder, US, Michigan, 01012031411')->isVisible(),
            'Shipping address is not deleted.'
        );
        $this->assertEquals(
            'Use Store Address',
            $this->webposIndex->getCheckoutEditCustomer()->getShippingAddressList()->getValue(),
            'Shipping address is not selected Use Store Address'
        );
        //Delete billing address
        $this->webposIndex->getCheckoutEditCustomer()->getDeleteBillingAddressIcon()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('.modal-popup');
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.modal-popup');
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getCheckoutEditCustomer()->getBillingAddressItem('John Doe, Culver City, US, California, 555-55-555-55')->isVisible(),
            'Billing address is not deleted.'
        );
        $this->assertEquals(
            'Use Store Address',
            $this->webposIndex->getCheckoutEditCustomer()->getBillingAddressList()->getValue(),
            'Shipping address is not selected Use Store Address'
        );

    }
}