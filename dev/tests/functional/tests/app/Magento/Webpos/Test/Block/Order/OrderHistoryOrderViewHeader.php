<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:30
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
/**
 * Class OrderHistoryOrderViewHeader
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryOrderViewHeader extends Block
{
	public function getOrderId()
	{
		return $this->_rootElement->find('div.id-order > label > span')->getText();
	}

	public function getStatus()
	{
		return $this->_rootElement->find('.status')->getText();
	}

	public function openAddOrderNote()
    {
        $this->_rootElement->find('.more-info')->click();
    }
}