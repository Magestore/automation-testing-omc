<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:31
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class OrderHistoryOrderViewFooter
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryOrderViewFooter extends Block
{
	public function getPrintButton()
	{
		return $this->_rootElement->find('button.print');
	}

	public function getInvoiceButton()
	{
		return $this->_rootElement->find('button.invoice');
	}

	public function getRowValue($label)
	{
		return $this->_rootElement->find('//*[@id="webpos_order_view_container"]/footer/div[1]/table/tbody/tr/td[text()="'.$label.'"]/../td[2]', Locator::SELECTOR_XPATH)->getText();
	}

	public function getSubtotal()
	{
		$label = 'Subtotal';
		return $this->getRowValue($label);
	}

	public function getShipping()
	{
		$label = 'Shipping';
		return $this->getRowValue($label);
	}

	public function getTax()
	{
		$label = 'Tax';
		return $this->getRowValue($label);
	}

	public function getDiscount()
	{
		$label = 'Discount';
		return $this->getRowValue($label);
	}

	public function getGrandTotal()
	{
		$label = 'Grand Total';
		return $this->getRowValue($label);
	}

	public function getTotalPaid()
	{
		$label = 'Total Paid';
		return $this->getRowValue($label);
	}

}