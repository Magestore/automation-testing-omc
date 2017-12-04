<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:09
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
/**
 * Class CheckoutPlaceOrder
 * @package Magento\Webpos\Test\Block\Checkout
 */
class CheckoutPlaceOrder extends Block
{
    public function waitCartLoader()
    {
        return $this->waitForElementNotVisible('.indicator');
    }

    public function getTopTotalPrice()
    {
        return $this->_rootElement->find('#webpos_checkout > header > div > span');
    }

    public function getRemainMoney()
    {
        return $this->_rootElement->find('.remain-money');
    }

    public function getButtonAddPayment()
    {
        return $this->_rootElement->find('#add_payment_button');
    }

    public function getButtonPlaceOrder()
    {
        return $this->_rootElement->find('#checkout_button');
    }
}