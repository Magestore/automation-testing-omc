<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/26/2018
 * Time: 10:27 AM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposEditCustomerEditSomeFieldsCC33Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Click on Add new customer icon
 * 3. Select a customer in list"
 *
 * Steps:
 * "1. Click to edit the selected customer
 * 2. Edit some fields
 * 3. Save"
 *
 * Acceptance:
 * "3.
 * - Close popup and customer information was updated
 * - Show message ""Success: The customer is saved successfully."""
 *
 */
class WebposEditCustomerEditSomeFieldsCC33Test extends Injectable
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
        $this->webposIndex->getCheckoutEditCustomer()->getFirstNameInput()->setValue('edit test');
        $this->webposIndex->getCheckoutEditCustomer()->getLastNameInput()->setValue('edit test');
        $this->webposIndex->getCheckoutEditCustomer()->getSaveButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="form-edit-customer"]');
        $this->webposIndex->getMsWebpos()->waitForElementVisible('#toaster');
        $this->assertEquals(
            'The customer is saved successfully.',
            $this->webposIndex->getToaster()->getWarningMessage()->getText(),
            'Customer save success message is wrong'
        );

        return ['customer' => $customer];
    }
}