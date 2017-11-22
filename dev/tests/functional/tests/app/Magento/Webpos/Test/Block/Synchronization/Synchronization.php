<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 09:14
 */

namespace Magento\Webpos\Test\Block\Synchronization;


use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class Synchronization extends Block
{
	public function getStockUpdateButton()
	{
		return $this->_rootElement->find('#sync_container > div > main > table > tbody > tr:nth-child(5) > td.stock_item.process-box > div > button');
	}

	public function getUpdateConfigurationSuccess()
    {
        return $this->_rootElement->find('#sync_container > div > main > table > tbody > tr:nth-child(2) > td.config.process-box > div > span');
    }

	public function getConfigurationUpdateButton()
	{
		return $this->_rootElement->find('#sync_container > div > main > table > tbody > tr:nth-child(2) > td.config.process-box > div > button');
	}

	public function getStockItemProgress()
	{
		return $this->_rootElement->find('.stock_item-myProgress');
	}

	public function getStockItemSuccess()
	{
		return $this->_rootElement->find('#sync_container > div > main > table > tbody > tr:nth-child(5) > td.stock_item.process-box > div > span');
	}

	public function getProductProgress()
	{
		return $this->_rootElement->find('.product-myProgress');
	}

	public function getProductSuccess()
	{
		return $this->_rootElement->find('#sync_container > div > main > table > tbody > tr:nth-child(4) > td.product.process-box > div > span');
	}

	public function getUpdateAllButton()
	{
		return $this->_rootElement->find('.update-all');
	}

	public function getReloadAllButton()
	{
		return $this->_rootElement->find('.reload-all');
	}

	// Get Item Row Elements
	public function getItemRow($name)
	{
		return $this->_rootElement->find('//*[@id="sync_container"]/div/main/table/tbody/tr/td[text()="'.$name.'"]/..', Locator::SELECTOR_XPATH);
	}

	public function getItemRowUpdateButton($name)
	{
		return $this->getItemRow($name)->find(' td.process-box > div > button');
	}

	public function getItemRowReloadButton($name)
	{
		return $this->getItemRow($name)->find('td:nth-child(4) > button');
	}

	public function getItemRowProgress($name)
	{
		return $this->getItemRow($name)->find('.myProgress');
	}

	public function getItemRowSuccess($name)
	{
		return $this->getItemRow($name)->find('.icon-iconPOS-success');
	}
	//////////////////////////////
}