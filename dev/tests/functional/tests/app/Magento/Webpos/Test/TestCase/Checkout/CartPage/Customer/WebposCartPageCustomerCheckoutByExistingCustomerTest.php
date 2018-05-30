<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/12/2017
 * Time: 11:16
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CartPage\Customer\AssertCartPageCustomerNameIsCorrect;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCartPageCustomerCheckoutByExistingCustomerTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer
 *
 * Precondition:
 * 1. Login webpos as a staff
 * Steps:
 * "1. Click on add customer icon
 * 2. Select an existing customer"
 *
 * Acceptance:
 * 1. Customer name is shown on the cart
 *
 */
class WebposCartPageCustomerCheckoutByExistingCustomerTest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * @var AssertCartPageCustomerNameIsCorrect
     */
    protected $assertCartPageCustomerNameIsCorrect;

    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
        )->run();

        $this->fixtureFactory = $fixtureFactory;
        $customer = $fixtureFactory->createByCode(
            'customer',
            ['dataset' => 'johndoe_with_addresses']
        );
        $customer->persist();
        return [
            'customer' => $customer
        ];
    }

    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
        AssertCartPageCustomerNameIsCorrect $assertCartPageCustomerNameIsCorrect
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
        $this->assertCartPageCustomerNameIsCorrect = $assertCartPageCustomerNameIsCorrect;
    }

    public function test(
        CatalogProductSimple $product,
        Customer $customer,
        $editCustomer = false,
        $useStoreAddress = false,
        Address $editAddress = null
    )
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Change customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        self::assertTrue(
            $this->webposIndex->getCheckoutChangeCustomer()->isVisible(),
            'CategoryRepository - TaxClass Page - Change customer popup is not shown'
        );
        $this->webposIndex->getCheckoutChangeCustomer()->search($customer->getEmail());
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        sleep(1);

        // CP37
        //Assert Customer name is shown
        $this->assertCartPageCustomerNameIsCorrect->processAssert($this->webposIndex, $customer);

        if ($editCustomer) {
            //Edit Customer Address
            $this->webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->click();
            self::assertTrue(
                $this->webposIndex->getCheckoutEditCustomer()->isVisible(),
                'CategoryRepository - TaxClass Page - Click Edit Customer- Edit customer popup is not shown'
            );
            if ($useStoreAddress) {
                $storeAddressText = 'Use Store Address';
                $this->webposIndex->getCheckoutEditCustomer()->clickShippingAddressSelect();
                $this->webposIndex->getCheckoutEditCustomer()->getShippingAddressItem($storeAddressText)->click();
                $this->webposIndex->getCheckoutEditCustomer()->clickBillingAddressSelect();
                $this->webposIndex->getCheckoutEditCustomer()->getBillingAddressItem($storeAddressText)->click();
            } else {
                $this->webposIndex->getCheckoutEditCustomer()->getEditShippingAddressIcon()->click();
                self::assertTrue(
                    $this->webposIndex->getCheckoutEditAddress()->isVisible(),
                    'CategoryRepository - TaxClass Page - Click Edit Address- Edit Address popup is not shown'
                );
                $this->webposIndex->getCheckoutEditAddress()->getPhoneInput()->setValue($editAddress->getTelephone());
                $this->webposIndex->getCheckoutEditAddress()->getStreet1Input()->setValue($editAddress->getStreet());
                $this->webposIndex->getCheckoutEditAddress()->getCityInput()->setValue($editAddress->getCity());
                $this->webposIndex->getCheckoutEditAddress()->getZipCodeInput()->setValue($editAddress->getPostcode());
                $this->webposIndex->getCheckoutEditAddress()->clickCountrySelect();
                $this->webposIndex->getCheckoutEditAddress()->getCountryItem($editAddress->getCountryId())->click();
                $this->webposIndex->getCheckoutEditAddress()->clickRegionSelect();
                $this->webposIndex->getCheckoutEditAddress()->getRegionItem($editAddress->getRegionId())->click();

                $this->webposIndex->getCheckoutEditAddress()->getSaveButton()->click();
                $this->webposIndex->getCheckoutEditAddress()->waingPageLoading();
            }
            sleep(3);
            $this->webposIndex->getCheckoutEditCustomer()->getSaveButton()->click();
            sleep(1);
            //Assert Customer save success
            self::assertEquals(
                'The customer is saved successfully.',
                $this->webposIndex->getToaster()->getWarningMessage()->getText(),
                'CategoryRepository - TaxClass Page - Edit Customer - save message is wrong'
            );
        }


        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);

        $orderId = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        if ($editCustomer) {
            $name = $customer->getFirstname() . ' ' . $customer->getLastname();
            $addressText = $editAddress->getCity() . ', ' . $editAddress->getRegionId() . ', ' . $editAddress->getPostcode() . ', ';
            $phone = $editAddress->getTelephone();
        } else {
            $name = $customer->getFirstname() . ' ' . $customer->getLastname();
            $address = $customer->getAddress();
            $addressText = $address[0]['city'] . ', ' . $address[0]['region_id'] . ', ' . $address[0]['postcode'] . ', ';
            $phone = $address[0]['telephone'];
        }
        return [
            'name' => $name,
            'address' => $addressText,
            'phone' => $phone,
            'orderId' => $orderId
        ];
    }
}