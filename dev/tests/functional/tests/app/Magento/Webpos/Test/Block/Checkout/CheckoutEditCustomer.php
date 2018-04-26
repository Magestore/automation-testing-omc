<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/12/2017
 * Time: 14:09
 */

namespace Magento\Webpos\Test\Block\Checkout;


use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class CheckoutEditCustomer extends Block
{
	public function getCancelButton()
	{
		return $this->_rootElement->find('.close');
	}

	public function getSaveButton()
	{
		return $this->_rootElement->find('.btn-save');
	}

	public function getFirstNameInput()
	{
		return $this->_rootElement->find('input[name="first-name"]');
	}

	public function getLastNameInput()
	{
		return $this->_rootElement->find('input[name="last-name"]');
	}

	public function getEmailInput()
	{
		return $this->_rootElement->find('input[name="email"]');
	}

	public function getEditShippingAddressIcon()
	{
		return $this->_rootElement->find('a[data-bind="click: editShippingPreview"]');
	}

	public function getDeleteShippingAddressIcon()
    {
        return $this->_rootElement->find('a[data-bind="click: deleteShippingPreview"]');
    }

	public function getEditBillingAddressIcon()
	{
		return $this->_rootElement->find('a[data-bind="click: editBillingPreview"]');
	}

	public function getDeleteBillingAddressIcon()
    {
        return $this->_rootElement->find('a[data-bind="click: deleteBillingPreview"]');
    }

	public function clickShippingAddressSelect()
	{
		$this->_rootElement->find('#shipping-checkout')->click();
		sleep(1);
	}

	public function getShippingAddressItem($text)
	{
		return $this->_rootElement->find('//*[@id="shipping-checkout"]/option[text()="'.$text.'"]', Locator::SELECTOR_XPATH);
	}

	public function clickBillingAddressSelect()
	{
		$this->_rootElement->find('#billing-checkout')->click();
		sleep(1);
	}

	public function getBillingAddressItem($text)
	{
		return $this->_rootElement->find('//*[@id="billing-checkout"]/option[text()="'.$text.'"]', Locator::SELECTOR_XPATH);
	}

	public function selectShippingAdress($text)
	{
	    $this->_rootElement->find('#shipping-checkout', Locator::SELECTOR_CSS,'select')->setValue($text);
	}
	public function selectBillingAdress($text)
	{
	    $this->_rootElement->find('#billing-checkout', Locator::SELECTOR_CSS,'select')->setValue($text);
	}

	// Shipping Info
	public function getShippingAddressBox()
	{
		return $this->_rootElement->find('.shipping-address .info-address-edit');
	}

	public function getShippingName()
	{
		return $this->_rootElement->find('.shipping-address .info-address-edit .customer-name');
	}

	public function getShippingAddress()
	{
		return $this->_rootElement->find('.shipping-address .info-address-edit .customer-address');
	}

	public function getShippingPhone()
	{
		return $this->_rootElement->find('.shipping-address .info-address-edit .customer-phone');
	}
	// End Shipping Info

	// Billing Info
	public function getBillingAddressBox()
	{
		return $this->_rootElement->find('.billing-address .info-address-edit');
	}

	public function getBillingName()
	{
		return $this->_rootElement->find('.billing-address .info-address-edit .customer-name');
	}

	public function getBillingAddress()
	{
		return $this->_rootElement->find('.billing-address .info-address-edit .customer-address');
	}

	public function getBillingPhone()
	{
		return $this->_rootElement->find('.billing-address .info-address-edit .customer-phone');
	}
	// End Billing Info
    public function getCustomerGroup()
    {
        return $this->_rootElement->find('[name="customer_group"]');
    }

    public function getShippingAddressList()
    {
        return $this->_rootElement->find('select[name="shipping_address"]', Locator::SELECTOR_CSS, 'select');
    }

    public function getBillingAddressList()
    {
        return $this->_rootElement->find('select[name="billing_address"]', Locator::SELECTOR_CSS, 'select');
    }

    public function getAddAddressButton()
    {
        return $this->_rootElement->find('.btn-add-address');
    }

    public function waitForPopupVisible(){
	    $this->waitForElementVisible('#form-edit-customer');
    }
}