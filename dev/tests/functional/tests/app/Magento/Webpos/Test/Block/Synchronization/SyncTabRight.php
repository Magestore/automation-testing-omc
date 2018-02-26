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
        $this->_rootElement->find('//*[@id="block-webpos-settings-synchronization"]/div/div[1]/div/div/ul/li[2]/a', Locator::SELECTOR_XPATH);
    }

    public function tabSyncData()
    {
        $this->_rootElement->find('//*[@id="block-webpos-settings-synchronization"]/div/div[1]/div/div/ul/li[1]/a', Locator::SELECTOR_XPATH);
    }

    public function buttonResetLocal()
    {
        $this->_rootElement->find('.btn-reset-db');
    }
}