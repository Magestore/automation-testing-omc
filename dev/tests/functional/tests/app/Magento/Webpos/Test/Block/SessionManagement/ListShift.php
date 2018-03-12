<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/9/2018
 * Time: 8:29 AM
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;

class ListShift extends Block
{
    public function getFirstItemShift()
    {
        return $this->_rootElement->find('.shift-item');
    }
}