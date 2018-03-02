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

class SyncErrorLogs extends Block
{
    public function getButtonAll()
    {
        return $this->_rootElement->find('#error-All');
    }
}