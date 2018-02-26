<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/23/2018
 * Time: 2:31 PM
 */

namespace Magento\Webpos\Test\Block\Synchronization;

use Magento\Mtf\Block\Block;

class SyncTabData extends Block
{
    public function btnUpdateAll()
    {
        return $this->_rootElement->find('.update-all');
    }
}