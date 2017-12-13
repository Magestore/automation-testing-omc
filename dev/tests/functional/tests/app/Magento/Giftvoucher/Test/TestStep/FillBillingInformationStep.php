<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/12/2017
 * Time: 10:27 AM
 */

namespace Magento\Giftvoucher\Test\TestStep;

use Magento\Checkout\Test\Page\CheckoutOnepage;
use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Checkout\Test\Constraint\AssertBillingAddressSameAsShippingCheckbox;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\ObjectManager;

class FillBillingInformationStep implements TestStepInterface
{
    /**
     * Onepage checkout page.
     *
     * @var CheckoutOnepage
     */
    protected $checkoutOnepage;

    /**
     * Billing Address fixture.
     *
     * @var Address
     */
    protected $billingAddress;

    /**
     * Shipping Address fixture.
     *
     * @var Address
     */
    protected $shippingAddress;

    /**
     * Customer fixture.
     *
     * @var Customer
     */
    protected $customer;

    /**
     * "Same as Shipping" checkbox value assertion.
     *
     * @var AssertBillingAddressSameAsShippingCheckbox
     */
    protected $assertBillingAddressCheckbox;

    /**
     * "Same as Shipping" checkbox expected value.
     *
     * @var string
     */
    protected $billingCheckboxState;

    /**
     * Customer shipping address data for select.
     *
     * @var array
     */
    private $billingAddressCustomer;

    /**
     * Flag for edit billing information.
     *
     * @var boolean
     */
    private $editBillingInformation;

    /**
     * Object manager instance.
     *
     * @var ObjectManager $objectManager
     */
    protected $objectManager;

    /**
     * @constructor
     * @param CheckoutOnepage $checkoutOnepage
     * @param AssertBillingAddressSameAsShippingCheckbox $assertBillingAddressCheckbox
     * @param Customer $customer
     * @param ObjectManager $objectManager
     * @param Address $billingAddress
     * @param Address $shippingAddress
     * @param string $billingCheckboxState
     * @param array|null $billingAddressCustomer
     * @param boolean $editBillingInformation
     */
    public function __construct(
        CheckoutOnepage $checkoutOnepage,
        AssertBillingAddressSameAsShippingCheckbox $assertBillingAddressCheckbox,
        Customer $customer,
        ObjectManager $objectManager,
        Address $billingAddress = null,
        Address $shippingAddress = null,
        $billingCheckboxState = null,
        $billingAddressCustomer = null,
        $editBillingInformation = true
    ) {
        $this->checkoutOnepage = $checkoutOnepage;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
        $this->assertBillingAddressCheckbox = $assertBillingAddressCheckbox;
        $this->customer = $customer;
        $this->objectManager = $objectManager;
        $this->billingCheckboxState = $billingCheckboxState;
        $this->billingAddressCustomer = $billingAddressCustomer;
        $this->editBillingInformation = $editBillingInformation;
    }

    /**
     * Fill billing address.
     *
     * @return array
     */
    public function run()
    {
        $billingAddress = $this->billingAddress;
        if ($this->billingCheckboxState) {
            $this->assertBillingAddressCheckbox->processAssert($this->checkoutOnepage, $this->billingCheckboxState);
        }
        if ($this->billingCheckboxState === 'Yes' && !$this->editBillingInformation) {
            return [
                'billingAddress' => $this->shippingAddress
            ];
        }
        if ($this->billingAddress) {
            $selectedPaymentMethod = $this->checkoutOnepage->getPaymentBlock()->getSelectedPaymentMethodBlock();
            if ($this->shippingAddress) {
                $selectedPaymentMethod->getBillingBlock()->unsetSameAsShippingCheckboxValue();
                $selectedPaymentMethod->getBillingBlock()->clickEdit();
            }
            $selectedPaymentMethod->getBillingBlock()->fillBilling($this->billingAddress);
            $billingAddress = $this->billingAddress;
        }
        if (isset($this->billingAddressCustomer['added'])) {
            $addressIndex = $this->billingAddressCustomer['added'];
            $billingAddress = $this->customer->getDataFieldConfig('address')['source']->getAddresses()[$addressIndex];
            $address = $this->objectManager->create(
                \Magento\Customer\Test\Block\Address\Renderer::class,
                ['address' => $billingAddress, 'type' => 'html_for_select_element']
            )->render();
            $selectedPaymentMethod = $this->checkoutOnepage->getPaymentBlock()->getSelectedPaymentMethodBlock();
            $selectedPaymentMethod->getBillingBlock()->unsetSameAsShippingCheckboxValue();
            $this->checkoutOnepage->getCustomAddressBlock()->selectAddress($address);
            $selectedPaymentMethod->getBillingBlock()->clickUpdate();
        }

        return [
            'billingAddress' => $billingAddress
        ];
    }
}