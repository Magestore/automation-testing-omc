<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 20/09/2017
 * Time: 15:46
 */

namespace Magento\Webpos\Test\Block\ManageStocks;


use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class ManageStocks extends Block
{
	public function getLocationName()
	{
		$name = $this->_rootElement->find('.location')->getText();
		$name = str_replace('Location: ', '', $name);
		return $name;
	}

	public function getLocationAddress()
	{
		return $this->_rootElement->find('.address')->getText();
	}

	public function search($string)
	{
		$this->_rootElement->find('#search-header-stock')->setValue($string);
	}

	public function getProduct($num)
	{
		$productRow = '#block-stock-list > div > div.wrap-table > table > tbody > tr:nth-child(%d)';
		return $this->_rootElement->find(sprintf($productRow, $num));
	}

	public function getProductName($num)
	{
		return $this->getProduct($num)->find('span[data-bind="text: name"]')->getText();
	}

	public function getProductSKU($num)
	{
		return $this->getProduct($num)->find('span[data-bind="text: sku"]')->getText();
	}

	public function getQtyInput($num)
	{
		return $this->getProduct($num)->find('.qty-edit');
	}

	public function getQtyInputByName($name)
	{
		return $this->_rootElement->find('//*[@id="block-stock-list"]/div/div[3]/table/tbody/tr/td[1]/span[text()="'.$name.'"]/../../td[3]/input', Locator::SELECTOR_XPATH);
	}

	public function getInStockCheckbox($num)
	{
		return $this->getProduct($num)->find('td:nth-child(4)');
	}

	public function isCheckboxChecked($divCheckbox)
	{
		$class = $divCheckbox->find('div')->getAttribute('class');
		return strpos($class, 'checked');
	}

	public function getUpdateButton($num)
	{
		return $this->getProduct($num)->find('td.a-right > a');
	}

	public function getUpdateAllButton()
	{
		return $this->_rootElement->find('#block-stock-list > div > div.wrap-table-header > table > thead > tr > th.a-right > a');
	}

	public function getUpdateSuccessIcon($num)
	{
		return $this->getProduct($num)->find('td.a-right > span');
	}
}