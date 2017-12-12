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
		return $this->_rootElement->find('#first_name_input');
	}

	public function getLastNameInput()
	{
		return $this->_rootElement->find('#last_name_input');
	}

	public function getEmailInput()
	{
		return $this->_rootElement->find('#customer_email_input');
	}

	public function getEditShippingAddressIcon()
	{
		return $this->_rootElement->find('a[data-bind="click: editShippingPreview"]');
	}

	public function getEditBillingAddressIcon()
	{
		return $this->_rootElement->find('a[data-bind="click: editBillingPreview"]');
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
}