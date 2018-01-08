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

	public function selectShippingAdress($text)
	{
	    $this->_rootElement->find('#shipping-checkout', Locator::SELECTOR_CSS,'select')->setValue($text);
	}
	public function selectBillingAdress($text)
	{
	    $this->_rootElement->find('#billing-checkout', Locator::SELECTOR_CSS,'select')->setValue($text);
	}
}