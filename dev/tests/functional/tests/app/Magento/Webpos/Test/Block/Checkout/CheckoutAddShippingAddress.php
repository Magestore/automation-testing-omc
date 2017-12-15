<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/12/2017
 * Time: 10:12
 */

namespace Magento\Webpos\Test\Block\Checkout;


use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class CheckoutAddShippingAddress extends Block
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

	public function getCompanyInput()
	{
		return $this->_rootElement->find('input[name="company"]');
	}

	public function getPhoneInput()
	{
		return $this->_rootElement->find('input[name="phone"]');
	}

	public function getStreet1Input()
	{
		return $this->_rootElement->find('input[name="street1"]');
	}

	public function getStreet2Input()
	{
		return $this->_rootElement->find('input[name="Street2"]');
	}

	public function getCityInput()
	{
		return $this->_rootElement->find('input[name="city"]');
	}

	public function getZipCodeInput()
	{
		return $this->_rootElement->find('input[name="zipcode"]');
	}

	public function getVATInput()
	{
		return $this->_rootElement->find('input[name="vat"]');
	}

	public function clickCountrySelect()
	{
		$this->_rootElement->find('select[name="country_id"]')->click();
		sleep(1);
	}

	public function getCountryItem($name)
	{
		return $this->_rootElement->find('//select[contains(@data-bind, "value: countryShipping")]/option[text()="' . $name . '"]', Locator::SELECTOR_XPATH);
	}

	public function clickRegionSelect()
	{
		$this->_rootElement->find('select[name="region_id"]')->click();
		sleep(1);
	}

	public function getRegionItem($name)
	{
		return $this->_rootElement->find('//select[contains(@data-bind, "value: regionIdShipping")]/option[text()="' . $name . '"]', Locator::SELECTOR_XPATH);
	}
}