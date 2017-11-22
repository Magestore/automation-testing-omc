<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 14/09/2017
 * Time: 16:17
 */

namespace Magento\Webpos\Test\Block\OrdersHistory;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class OrdersHistory extends Block
{
    public function search($string)
    {
        $this->_rootElement->find('#search-header-order')->setValue($string);
    }

    public function getFirstOrder()
    {
        return $this->_rootElement->find('.list-orders .order-item');
    }

	public function getSecondOrder()
	{
		return $this->_rootElement->find('#webpos_order_list > div > div.wrap-item-order > ul:nth-child(2) > li:nth-child(2)');
	}

	public function getOrderViewContainer()
	{
		return $this->_rootElement->find('#webpos_order_view_container');
	}

    public function getOrderId()
    {
        return $this->_rootElement->find('#webpos_order_view_container > header > nav > div.id-order > label > span')->getText();
    }

    public function getStatus()
    {
        return $this->_rootElement->find('.status')->getText();
    }

    public function getPrice()
    {
        return $this->_rootElement->find('#webpos_order_view_container > header > div.sum-info-top > div.life-time-left > span')->getText();
    }

	public function getTotalDueContainer()
	{
		return $this->_rootElement->find('#webpos_order_view_container > header > div.total-due');
	}

	public function getTotalDue()
	{
		$value = $this->_rootElement->find('#webpos_order_view_container > header > div.total-due > label > span.price')->getText();
		return substr($value, 1);
	}

    public function getTotalPaid()
    {
	    $labelText = 'Total Paid';
	    $value = $this->_rootElement->find('//*[@id="webpos_order_view_container"]/footer/div[1]/table/tbody/tr/td[text()="'.$labelText.'"]/../td[2]', Locator::SELECTOR_XPATH)->getText();
	    return substr($value, 1);
    }

	public function getTotalRefunded()
	{
		$labelText = 'Total Refunded';
		$value = $this->_rootElement->find('//*[@id="webpos_order_view_container"]/footer/div[1]/table/tbody/tr/td[text()="'.$labelText.'"]/../td[2]', Locator::SELECTOR_XPATH)->getText();
		return substr($value, 1);
	}

    public function getChange()
    {
        $value = $this->_rootElement->find('#webpos_order_view_container > footer > div.col-sm-offset-6 > table > tbody > tr:nth-child(5) > td.a-right')->getText();
        return substr($value, 1);
    }

    public function getTakePaymentButton()
    {
        return $this->_rootElement->find('a.take-payment');
    }

	public function getPayLaterPayment($text)
	{
		return $this->_rootElement->find('//div[@data-bind="foreach:$parent.getPayLaterPayment()"]/div/label[text()="'.$text.'"]', Locator::SELECTOR_XPATH);
	}

    public function getPrintButton()
    {
        return $this->_rootElement->find('button.print');
    }

    public function getInvoiceButton()
    {
        return $this->_rootElement->find('button.invoice');
    }

    public function getSaveButton()
    {
        return $this->_rootElement->find('//*[@id="orders_history_container"]/div/div[11]/div/div/form/div[1]/button[2]', Locator::SELECTOR_XPATH);
    }

    // More info - Actions box
    public function getMoreInfoButton()
    {
        return $this->_rootElement->find('#webpos_order_view_container > header > nav > div.more-info > a');
    }

    public function getActionsBox()
    {
        return $this->_rootElement->find('#form-add-note-order');
    }

    public function getAction($text)
    {
        return $this->_rootElement->find('//*[@id="form-add-note-order"]/ul/li/a[text()="' . $text . '"]', Locator::SELECTOR_XPATH);
    }

    ////////////////

    // Send Email Popup
    public function getSendEmailPopupContainer()
    {
        return $this->_rootElement->find('#send-email-order');
    }

    public function getCancelSendEmailButton()
    {
        return $this->getSendEmailPopupContainer()->find('button.close');
    }

    public function getSendButton()
    {
        return $this->getSendEmailPopupContainer()->find('button.btn-save');
    }

    public function getEmailInputBox()
    {
        return $this->getSendEmailPopupContainer()->find('#input-send-email-order');
    }
    ///////////////////

    // Add Comment Popup
    public function getAddCommentPopupContainer()
    {
        return $this->_rootElement->find('#add-comment-order');
    }

    public function getCancelAddCommentButton()
    {
        return $this->getAddCommentPopupContainer()->find('button.close');
    }

    public function getSaveCommentButton()
    {
        return $this->getAddCommentPopupContainer()->find('button.btn-save');
    }

    public function getCommentInputBox()
    {
        return $this->getAddCommentPopupContainer()->find('#input-add-comment-order');
    }

    public function getCommentAreaBox()
    {
        return $this->_rootElement->find('#input-add-cancel-comment-order');
    }
    /////////////////////

    // Shipment Popup
    public function getShipmentPopupContainer()
    {
        return $this->_rootElement->find('#shipment-popup');
    }

	public function getShipCancelButton()
	{
		return $this->getShipmentPopupContainer()->find('button.close');
	}

	public function getShipSummitButton()
	{
		return $this->getShipmentPopupContainer()->find('#shipment-popup-form > div.modal-body > div.actions > button');
	}

	public function getShipCommentBox()
	{
		return $this->getShipmentPopupContainer()->find('textarea[name="comment_text"]');
	}

	public function getShipTrackNumberBox()
	{
		return $this->getShipmentPopupContainer()->find('input[name="tracking[1][number]"]');
	}

	public function getShipItemRow($name)
	{
		return $this->getShipmentPopupContainer()->find('//*[@id="shipment-popup"]/div/div/form/div[2]/div[1]/table/tbody/tr/td/h4[text()="'.$name.'"]/../..', Locator::SELECTOR_XPATH);
	}

	public function getShipItemQty($name)
	{
		return $this->getShipItemRow($name)->find('td:nth-child(4)')->getText();
	}

	public function getShipItemQtyInputBox($name)
	{
		return $this->getShipItemRow($name)->find('.input-qty');
	}

	public function getShipSendEmailCheckbox()
	{
		return $this->getShipmentPopupContainer()->find('#send_email_ship_popup');
	}
	/////////////////////

	// Cancel Order Popup
	public function getCancelOrderPopup()
	{
		return $this->_rootElement->find('#add-cancel-comment-order');
	}

	public function getCancelOrderCancelButton()
	{
		return $this->getCancelOrderPopup()->find('.close');
	}

	public function getCancelOrderSaveButton()
	{
		return $this->getCancelOrderPopup()->find('.btn-save');
	}

	public function getCancelOrderCommentInput()
	{
		return $this->getCancelOrderPopup()->find('#input-add-cancel-comment-order');
	}
	/////////////////////

	// Take Payment Popup
	public function getTakePaymentPopup()
	{
		return $this->_rootElement->find('#payment-popup');
	}

	public function getTakePaymentCancelButton()
	{
		return $this->getTakePaymentPopup()->find('button.close');
	}

	public function getTakePaymentHeaderSubmitAction()
	{
		return $this->getTakePaymentPopup()->find('.btn-save');
	}

	public function getTakePaymentAddMorePaymentButton()
	{
		return $this->getTakePaymentPopup()->find('#add_more_payment_btn');
	}

	public function getTakePaymentSubmitButton()
	{
		return $this->getTakePaymentPopup()->find('button[data-bind="text: $t(\'SUBMIT\'), click: submit"]');
	}

	public function getTakePaymentPaymentList()
	{
		return $this->getTakePaymentPopup()->find('#order_payment_list_container > div');
	}

	public function getTakePaymentPaymentItem($text)
	{
		return $this->getTakePaymentPopup()->find('//*[@id="order_payment_list_container"]/div/div/div/div/label[text()="'.$text.'"]/..', Locator::SELECTOR_XPATH);
	}

	public function getTakePaymentPaymentInputBox($text)
	{
		return $this->getTakePaymentPopup()->find('//*[@id="payment_selected"]/div/div/div/div[1]/label[text()="'.$text.'"]/../../div[3]/div/input', Locator::SELECTOR_XPATH);
	}

	public function getTakePaymentMorePaymentContainer()
	{
		return $this->getTakePaymentPopup()->find('#order_more_payment_container');
	}

	public function getTakePaymentMorePaymentItem($text)
	{
		return $this->getTakePaymentPopup()->find('//*[@id="order_more_payment_container"]/div/div/div/div/label[text()="'.$text.'"]/..', Locator::SELECTOR_XPATH);
	}
	/////////////////////

	// Create Invoice Popup
	public function getInvoicePopup()
	{
		return $this->_rootElement->find('#invoice-popup');
	}

	public function getInvoiceCancelButton()
	{
		return $this->getInvoicePopup()->find('button.close');
	}

	public function getInvoiceCommentInput()
	{
		return $this->getInvoicePopup()->find('textarea[name="comment_text"]');
	}

	public function getInvoiceSendEmailCheckbox()
	{
		return $this->getInvoicePopup()->find('#send_email_ship');
	}

	public function getInvoiceSubmitButton()
	{
		return $this->getInvoicePopup()->find('button[data-bind="text: $t(\'Submit Invoice\'), click: submit"]');
	}

	public function getInvoiceItemRow($name)
	{
		return $this->getInvoicePopup()->find('//*[@id="invoice-popup-form"]/div[2]/div[2]/table/tbody/tr/td[1]/h4[text()="'.$name.'"]/../..', Locator::SELECTOR_XPATH);
	}

	public function getInvoiceItemOrderedQty($name)
	{
		return $this->getInvoiceItemRow($name)->find('span[data-bind="text:  item.qty_ordered"]')->getText();
	}

	public function getInvoiceItemQtyToInvoiceInput($name)
	{
		return $this->getInvoiceItemRow($name)->find('.input-qty');
	}

	/////////////////

	// Refund Popup
	public function getRefundPopup()
	{
		return $this->_rootElement->find('#refund-popup');
	}

	public function getRefundCancelButton()
	{
		return $this->getRefundPopup()->find('button.close');
	}

	public function getRefundRefundOfflineButton()
	{
		return $this->getRefundPopup()->find('#creditmemo-popup-form > div.popup-header > button.btn-save');
	}

	public function getRefundSubmitButton()
	{
		return $this->getRefundPopup()->find('#creditmemo-popup-form > div.modal-body > div.actions > button.submit-refund');
	}

	public function getRefundSendEmailCheckbox()
	{
		return $this->getRefundPopup()->find('#send_email_creditmemo_popup');
	}

	public function getRefundCommentBox()
	{
		return $this->getRefundPopup()->find('textarea[name="comment_text"]');
	}

	public function getRefundAdjustRefundBox()
	{
		return $this->getRefundPopup()->find('input[name="adjustment_positive"]');
	}

	public function getRefundAdjustFee()
	{
		return $this->getRefundPopup()->find('input[name="adjustment_negative"]');
	}

	public function getRefundStoreCreditInput()
	{
		return $this->getRefundPopup()->find('input[data-bind="value:creditAmount, event:{change:saveCreditAmount}"]');
	}

	public function getRefundFirstItemRow()
	{
		return $this->getRefundPopup()->find('#creditmemo-popup-form > div.modal-body > div.wrap-table > table > tbody > tr:nth-child(1)');
	}

	public function getRefundItemRow($name)
	{
		return $this->getRefundPopup()->find('//*[@id="creditmemo-popup-form"]/div[2]/div[1]/table/tbody/tr/td[1]/h4[text()="'.$name.'"]/../..', Locator::SELECTOR_XPATH);
	}

	public function getRefundItemQty($name)
	{
		return $this->getRefundItemRow($name)->find('td[data-bind="text: item.qty_invoiced - item.qty_refunded"]')->getText();
	}

	public function getRefundItemQtyToRefundInput($name)
	{
		return $this->getRefundItemRow($name)->find('.refund-input-qty');
	}

	public function getRefundItemReturnToStockCheckbox($name)
	{
		return $this->getRefundItemRow($name)->find('input[data-bind="attr: {name: \'items[\'+item.item_id+\'][back_to_stock]\'}"]');
	}

	//////////////////

	// Filter Status
	public function getFilterStatusButton($status)
	{
		return $this->_rootElement->find('//*[@id="webpos_order_list"]/div/div[1]/ul/li/a[text()="'.$status.'"]/..', Locator::SELECTOR_XPATH);
	}
	////////////////

    public function submitRefund()
    {
        return $this->_rootElement->find('#orders_history_container > div > div.modal.fade.add-comment.ship-refund.in > div > div > form > div.modal-body > div.actions > button');
    }
}