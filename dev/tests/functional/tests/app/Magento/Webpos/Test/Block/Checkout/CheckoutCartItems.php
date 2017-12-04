<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:07
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
/**
 * Class CheckoutCartItems
 * @package Magento\Webpos\Test\Block\Checkout
 */
class CheckoutCartItems extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCartItem($name)
    {
//        return $this
    }
    public function getProductImage()
    {
        return $this->_rootElement->find('li:nth-child(1) > div > div > div.product-img');
    }

    public function getProductPrice()
    {
        return $this->_rootElement->find('.product-item .price');
    }

    public function getIconDeleteItem()
    {
        return $this->_rootElement->find('.product-item .icon-iconPOS-delete');
    }
}