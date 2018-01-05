<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:07
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
/**
 * Class CheckoutCartItems
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\CategoryRepository
 */
class CheckoutCartItems extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getProductImage()
    {
        return $this->_rootElement->find('.product-item .product-img');
    }

    public function getProductPrice()
    {
        return $this->_rootElement->find('.product-item .price');
    }

    public function getIconDeleteItem()
    {
        return $this->_rootElement->find('.product-item .remove-icon');
    }

	public function getFirstCartItem()
	{
		return $this->_rootElement->find('.product-item');
	}

    public function getCartItem($name)
    {
        return $this->_rootElement->find('//li/div/div/div[2]/h4[text()="'.$name.'"]/../../../..', Locator::SELECTOR_XPATH);
    }

    public function getCartItemName($name)
    {
        return $this->getCartItem($name)->find('.product-name')->getText();
    }

    public function getCartItemQty($name)
    {
        return $this->getCartItem($name)->find('.number');
    }

    public function getCartItemPrice($name)
    {
        return $this->getCartItem($name)->find('.price');
    }

    public function getValueItemPrice($name)
    {
        $price = $this->getCartItemPrice($name)->getText();
        return substr($price, 1);
    }

    public function getCartOriginalItemPrice($name)
    {
        return $this->getCartItem($name)->find('.original-price');
    }

    public function getValueOriginalItemPrice($name)
    {
        $value = $this->getCartOriginalItemPrice($name)->getText();
        return substr($value, 6);
    }
}