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
 * Class OrderHistoryRefund
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryRefund extends Block
{
	public function waitForCancelButtonVisible()
	{
		return $this->waitForElementVisible('button.close');
	}

	public function getCancelButton()
	{
		return $this->_rootElement->find('button.close');
	}

	public function getRefundOfflineButton()
	{
		return $this->_rootElement->find('#creditmemo-popup-form > div.popup-header > button.btn-save');
	}

	public function getSubmitButton()
	{
		return $this->_rootElement->find('#creditmemo-popup-form > div.modal-body > div.actions > button.submit-refund');
	}

	public function getSendEmailCheckbox()
	{
		return $this->_rootElement->find('#send_email_creditmemo_popup');
	}

	public function getCommentBox()
	{
		return $this->_rootElement->find('textarea[name="comment_text"]');
	}

	public function getAdjustRefundBox()
	{
		return $this->_rootElement->find('input[name="adjustment_positive"]');
	}

	public function getAdjustFee()
	{
		return $this->_rootElement->find('input[name="adjustment_negative"]');
	}

	public function getStoreCreditInput()
	{
		return $this->_rootElement->find('input[data-bind="value:creditAmount, event:{change:saveCreditAmount}"]');
	}

	public function getFirstItemRow()
	{
		return $this->_rootElement->find('#creditmemo-popup-form > div.modal-body > div.wrap-table > table > tbody > tr:nth-child(1)');
	}

	public function getItemRow($name)
	{
		return $this->_rootElement->find('//*[@id="creditmemo-popup-form"]/div[2]/div[1]/table/tbody/tr/td[1]/h4[text()="'.$name.'"]/../..', Locator::SELECTOR_XPATH);
	}

	public function getItemQty($name)
	{
		return $this->getItemRow($name)->find('td[data-bind="text: item.qty_invoiced - item.qty_refunded"]')->getText();
	}

	public function getItemQtyToRefundInput($name)
	{
		return $this->getItemRow($name)->find('.refund-input-qty');
	}

	public function getItemReturnToStockCheckbox($name)
	{
		return $this->getItemRow($name)->find('input[data-bind="attr: {name: \'items[\'+item.item_id+\'][back_to_stock]\'}"]');
	}

	public function getItemPrice($name)
	{
		return $this->getItemRow($name)->find('td[data-bind="text: $parent.convertAndFormatPrice(item.base_price_incl_tax)"]')->getText();
	}

	public function getRefundShipping()
	{
		return $this->_rootElement->find('input[name="shipping_amount"]');
	}

	public function getTableHeader($title)
    {
        $template = './/table//th[text()= "%s"]';
        return $this->_rootElement->find(sprintf($template, $title), Locator::SELECTOR_XPATH);
    }
}