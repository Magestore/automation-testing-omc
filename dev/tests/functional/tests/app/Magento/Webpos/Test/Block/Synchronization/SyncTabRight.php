<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/23/2018
 * Time: 2:30 PM
 */
namespace Magento\Webpos\Test\Block\Synchronization;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class SyncTabRight extends Block
{
    public function tabErrorLogs()
    {
        return $this->_rootElement->find('//div/div/ul/li[2]/a', Locator::SELECTOR_XPATH);
    }

    public function tabSyncData()
    {
        return $this->_rootElement->find('//div/div/ul/li[1]/a', Locator::SELECTOR_XPATH);
    }

    public function buttonResetLocal()
    {
        return $this->_rootElement->find('.btn-reset-db');
    }
}