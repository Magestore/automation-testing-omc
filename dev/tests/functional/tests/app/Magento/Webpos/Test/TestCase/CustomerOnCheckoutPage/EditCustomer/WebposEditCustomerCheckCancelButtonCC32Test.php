<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/26/2018
 * Time: 10:20 AM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposEditCustomerCheckCancelButtonCC32Test extends Injectable
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
        $customer = $this->fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
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
        $this->webposIndex->getCheckoutCartHeader()->getIconEditCustomer()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-edit-customer"]');
        $this->webposIndex->getCheckoutEditCustomer()->getCancelButton()->click();
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getCheckoutEditCustomer()->isVisible(),
            'Edit customer popup is not hidden.'
        );
        return ['customer' => $customer];
    }
}