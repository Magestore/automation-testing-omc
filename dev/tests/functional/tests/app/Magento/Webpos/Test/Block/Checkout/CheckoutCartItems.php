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

	public function getFirstCartItemQty()
	{
		return $this->_rootElement->find('//*[@id="order-items"]/li[1]/div/div/div[1]/a[@data-bind="text:qty"]', Locator::SELECTOR_XPATH);
	}

	public function getFirstCartItemOption()
    {
        return $this->getFirstCartItem()->find('.item-options');
    }

    public function getCartItem($name)
    {
        return $this->_rootElement->find('//li/div/div/div[2]/h4[text()="'.$name.'"]/../../../..', Locator::SELECTOR_XPATH);
    }

    public function getCartItemName($name)
    {
        return $this->_rootElement->find('//li/div/div/div[2]/h4[text()="'.$name.'"]', Locator::SELECTOR_XPATH)->getText();
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

	public function getCartItemImage($name)
	{
		return $this->getCartItem($name)->find('.product-img');
	}
    public function isCartItem()
    {
        return $this->_rootElement->find('.product-item')->isPresent();

    }
    public function getCartItemByOrderTo($i)
    {
        return $this->_rootElement->find('//*[@id="order-items"]/li['.$i.']', Locator::SELECTOR_XPATH);

    }
    public function getNameCartItemByOrderTo($i)
    {
        return $this->_rootElement->find('//*[@id="order-items"]/li['.$i.']', Locator::SELECTOR_XPATH)->find('.product-name')->getText();

    }
    public function getPriceCartItemByOrderTo($i)
    {
        return floatval(str_replace('$','',$this->_rootElement->find('//*[@id="order-items"]/li['.$i.']', Locator::SELECTOR_XPATH)->find('.price')->getText()));

    }
    public function getAttributeCartItemByOrderTo($i)
    {
        return $this->_rootElement->find('//*[@id="order-items"]/li['.$i.']', Locator::SELECTOR_XPATH)->find('.item-options')->getText();

    }
    public function isQtyDisplay($i)
    {
        return $this->_rootElement->find('//*[@id="order-items"]/li['.$i.']', Locator::SELECTOR_XPATH)->find('.product-item .product-img')->find('.number')->isPresent();

    }
    public function getQtyDisplay($i)
    {
        return floatval($this->_rootElement->find('//*[@id="order-items"]/li['.$i.']', Locator::SELECTOR_XPATH)->find('.product-item .product-img')->find('.number')->getText());

    }

    public function getOriginPriceCartItemByOrderTo($i)
    {
        $value = $this->_rootElement->find('//*[@id="order-items"]/li['.$i.']', Locator::SELECTOR_XPATH)->find('.price')->getText();
        return floatval(substr($value, 6));
    }
}