<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:32
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class OrderHistoryInvoice
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryInvoice extends Block
{
	public function getCancelButton()
	{
		return $this->_rootElement->find('button.close');
	}

	public function getCommentInput()
	{
		return $this->_rootElement->find('textarea[name="comment_text"]');
	}

	public function getSendEmailCheckbox()
	{
		return $this->_rootElement->find('#send_email_ship');
	}

	public function getSubmitButton()
	{
		return $this->_rootElement->find('button[data-bind="text: $t(\'Submit Invoice\'), click: submit"]');
	}

	public function getItemRow($name)
	{
		return $this->_rootElement->find('//*[@id="invoice-popup-form"]/div[2]/div[2]/table/tbody/tr/td[1]/h4[text()="'.$name.'"]/../..', Locator::SELECTOR_XPATH);
	}

	public function getItemOrderedQty($name)
	{
		return $this->getItemRow($name)->find('span[data-bind="text:  item.qty_ordered"]')->getText();
	}

	public function getItemQtyToInvoiceInput($name)
	{
		return $this->getItemRow($name)->find('.input-qty');
	}
}