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
 * Class OrderHistoryOrderViewContent
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryOrderViewContent extends Block
{
	public function getBillingName()
	{
		return $this->_rootElement->find('label[data-bind="text: $parent.getCustomerName(\'billing\')"]')->getText();
	}

	public function getBillingAddress()
	{
		return $this->_rootElement->find('span[data-bind="text: $parent.getAddress(\'billing\')"]')->getText();
	}

	public function getBillingPhone()
	{
		return $this->_rootElement->find('span[data-bind="text: $parent.getAddressType(\'billing\').telephone"]')->getText();
	}

	public function getShippingName()
	{
		return $this->_rootElement->find('label[data-bind="text: $parent.getCustomerName(\'shipping\')"]')->getText();
	}

	public function getShippingAddress()
	{
		return $this->_rootElement->find('span[data-bind="text: $parent.getAddress(\'shipping\')"]')->getText();
	}

	public function getShippingPhone()
	{
		return $this->_rootElement->find('span[data-bind="text: $parent.getAddressType(\'shipping\').telephone"]')->getText();
	}

}