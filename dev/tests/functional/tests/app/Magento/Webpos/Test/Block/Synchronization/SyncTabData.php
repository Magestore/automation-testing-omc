<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/23/2018
 * Time: 2:31 PM
 */

namespace Magento\Webpos\Test\Block\Synchronization;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class SyncTabData extends Block
{
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