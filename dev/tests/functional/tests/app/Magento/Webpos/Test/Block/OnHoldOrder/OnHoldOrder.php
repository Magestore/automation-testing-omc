<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/09/2017
 * Time: 13:35
 */

namespace Magento\Webpos\Test\Block\OnHoldOrder;


use Magento\Mtf\Block\Block;

class OnHoldOrder extends Block
{
	public function getFirstOrder()
	{
		return $this->_rootElement->find('.list-orders .order-item');
	}

	public function getDeleteButton()
	{
		return $this->_rootElement->find('button[data-bind="text: $t(\'Delete\'), click: cancelOnhold"]');
	}

	public function getCheckoutButton()
	{
		return $this->_rootElement->find('button[data-bind="text: $t(\'Checkout\'), click: continueProcessing"]');
	}

	public function getOrderId()
	{
		return $this->_rootElement->find('.id-order label span')->getText();

	}

	public function getSubTotal()
	{
		return $this->_rootElement->find('#on_hold_orders_container > div > div.col-sm-8.col-left > footer > div.col-sm-offset-6 > table > tbody > tr:nth-child(1) > td.a-right')->getText();
	}

	public function getTotal()
	{
		return $this->_rootElement->find('#on_hold_orders_container > div > div.col-sm-8.col-left > footer > div.col-sm-offset-6 > table > tbody > tr:nth-child(3) > td.a-right')->getText();
	}

	public function search($string)
	{
		$this->_rootElement->find('#search-header-order-hold')->setValue($string);
	}
}