<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/17/2018
 * Time: 2:12 PM
 */

namespace Magento\Webpos\Test\Block\Checkout;
use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class CheckoutAddMorePayment extends Block
{
    public function getCashIn()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-cashforpos');
    }
    public function getCashOnDeliveryMethod()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-codforpos');
    }
    public function getCreditCard()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-ccforpos');
    }
    public function getCustomPayment1()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-cp1forpos');
    }
    public function getCustomPayment2()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-cp2forpos');
    }
}