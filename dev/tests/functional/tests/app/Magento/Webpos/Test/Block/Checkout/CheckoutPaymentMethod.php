<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:10
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
/**
 * Class CheckoutPaymentMethod
 * @package Magento\Webpos\Test\Block\Checkout
 */
class CheckoutPaymentMethod extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCashInMethod()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-cashforpos');
    }
    public function getCashOnDeliveryMethod()
    {
        return $this->_rootElement->find('.icon-iconPOS-payment-codforpos');
    }
}