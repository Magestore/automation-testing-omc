<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:11
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;

/**
 * Class CheckoutSuccess
 * @package Magento\Webpos\Test\Block\CategoryRepository
 */
class CheckoutSuccess extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getNotifyOrder()
    {
        return $this->_rootElement->find('.notify-order');
    }

    public function getSuccessOrderMessage()
    {
        return $this->_rootElement->find('div[data-bind="i18n:\'Order has been created successfully\'"]');
    }

    public function getSuccessOrderId()
    {
        return $this->_rootElement->find('span[data-bind="i18n:\'Order ID:  \'"]');
    }

    public function getOrderId()
    {
        return $this->_rootElement->find('strong[data-bind="text:getOrderIdMessage()"]');
    }

    public function getCustomerEmail()
    {
        return $this->_rootElement->find('.customer-email');
    }

    public function getSendEmailButton()
    {
        return $this->_rootElement->find('.btn-submit');
    }

    public function getPrintButton()
    {
        return $this->_rootElement->find('.add-payment');
    }

    public function getNewOrderButton()
    {
        return $this->_rootElement->find('.checkout-actions');
    }

    public function waitForLoadingIndicator()
    {
        $this->waitForElementNotVisible('.indicator');
    }

    public function isSuccessMessageVisible()
    {
        return $this->_rootElement->isVisible();
    }
}