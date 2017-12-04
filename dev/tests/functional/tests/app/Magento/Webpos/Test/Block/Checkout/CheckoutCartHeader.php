<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:06
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
/**
 * Class CheckoutCartHeader
 * @package Magento\Webpos\Test\Block\Checkout
 */
class CheckoutCartHeader extends Block
{
	/**
	 * @return \Magento\Mtf\Client\ElementInterface
	 * get Icon Delete Cart
	 */
	public function getIconDeleteCart()
	{
		return $this->_rootElement->find('#empty_cart');
	}

	public function getIconAddCustomer()
	{
		return $this->_rootElement->find('.icon-iconPOS-change-customer');
	}

	public function getIconActionMenu()
	{
		return $this->_rootElement->find('.icon-iconPOS-more');
	}

	public function getAddMultiOrder()
	{
		return $this->_rootElement->find('.pull-right');
	}

	public function getCustomerTitleDefault()
	{
		return $this->_rootElement->find('.add-customer > .title-header-page');
	}
}