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
/**
 * Class SyncTabData
 * @package Magento\Webpos\Test\Block\Synchronization
 */
class SyncTabData extends Block
{
	public function waitUpdateAllButton()
	{
        $updateAllButton = $this->_rootElement->find('.update-all');
        $browser = $this->_rootElement;
        $browser->waitUntil(
            function () use ($updateAllButton) {
                return $updateAllButton->isVisible() ? true : null;
            }
        );
	}
	public function getUpdateAllButton()
	{
		return $this->_rootElement->find('.update-all');
	}

    public function waitReloadAllButton()
    {
        $reloadAllButton = $this->_rootElement->find('.reload-all');
        $browser = $this->_rootElement;
        $browser->waitUntil(
            function () use ($reloadAllButton) {
                return $reloadAllButton->isVisible() ? true : null;
            }
        );
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

	public function waitItemRowReloadButton($name)
	{
        $browser = $this->_rootElement;
        $browser->click();
        $itemRowReloadButton = $this->getItemRow($name)->find('td:nth-child(4) > button');
        $browser->waitUntil(
            function () use ($itemRowReloadButton) {
                return $itemRowReloadButton->isVisible() ? true : null;
            }
        );
	}

	public function getItemRowReloadButton($name)
	{
		return $this->getItemRow($name)->find('td:nth-child(4) > button');
	}

    public function waitItemRowProgress($name)
    {
        $browser = $this->_rootElement;
        $browser->click();
        $itemRowProgress = $this->getItemRow($name)->find('.myProgress');
        $browser->waitUntil(
            function () use ($itemRowProgress) {
                return $itemRowProgress->isVisible() ? true : null;
            }
        );
    }
	public function getItemRowProgress($name)
	{
		return $this->getItemRow($name)->find('.myProgress');
	}

    public function waitItemRowSuccess($name)
    {
        $browser = $this->_rootElement;
        $browser->click();
        $itemRowSuccess = $this->getItemRow($name)->find('.icon-iconPOS-success');
        $browser->waitUntil(
            function () use ($itemRowSuccess) {
                return $itemRowSuccess->isVisible() ? true : null;
            }
        );
    }
	public function getItemRowSuccess($name)
	{
		return $this->getItemRow($name)->find('.icon-iconPOS-success');
	}
	//////////////////////////////
}