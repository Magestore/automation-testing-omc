<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 28/09/2017
 * Time: 14:00
 */

namespace Magento\Webpos\Test\Block\General;


use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class General extends Block
{
	// Checkout Tab
	public function getCheckoutTab()
	{
		return $this->_rootElement->find('a[href="#checkout_setting"]');
	}
	// Catalog Tab
	public function getCatalogTab()
	{
		return $this->_rootElement->find('a[href="#catalog"]');
	}

	public function getOutstockDisplay()
	{
		return $this->_rootElement->find('#outstock-display');
	}

	public function selectOutstockDisplay($value)
	{
		$this->getOutstockDisplay()->click();
		$this->_rootElement->find('//*[@id="outstock-display"]/option[text()="'.$value.'"]', Locator::SELECTOR_XPATH)->click();
	}
	// Currency Tab
	public function getCurrencyTab()
	{
		return $this->_rootElement->find('a[href="#currency-account"]');
	}

	public function selectCurrency($value)
	{
		$this->_rootElement->find('#currency')->click();
		$this->_rootElement->find('#currency > option[value="'.$value.'"]')->click();
	}
	// Store View Tab
	public function getStoreViewTab()
	{
		return $this->_rootElement->find('a[href="#store-account"]');
	}

}