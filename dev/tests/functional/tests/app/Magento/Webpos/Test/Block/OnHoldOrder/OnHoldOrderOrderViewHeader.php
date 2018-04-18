<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/5/2018
 * Time: 1:41 PM
 */

namespace Magento\Webpos\Test\Block\OnHoldOrder;

use Magento\Mtf\Block\Block;

/**
 * Class OnHoldOrderOrderViewHeader
 * @package Magento\Webpos\Test\Block\OnHoldOrder
 */
class OnHoldOrderOrderViewHeader extends Block
{
    public function getBlockIdOrder()
    {
        return $this->_rootElement->find('.id-order');
    }

    public function getIdOrder()
    {
        return $this->getBlockIdOrder()->find('.title-header-page > span')->getText();
    }

    public function getCreateAt()
    {
        return $this->_rootElement->find('label[data-bind="text: $t(\'Created Date: \')"]');
    }

    public function getServeBy()
    {
        return $this->_rootElement->find('label[data-bind="text: $t(\'Served by: \')"]');
    }

    public function getStatus()
    {
        return $this->_rootElement->find('label[data-bind="text: $t(\'Status: \')"]');
    }
}