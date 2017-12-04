<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:05
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
/**
 * Class CheckoutProductList
 * @package Magento\Webpos\Test\Block\Checkout
 */
class CheckoutProductList extends Block
{
	public function getFirstProduct()
	{
		return $this->_rootElement->find('.product-item');
	}

	public function getFirstProductPrice()
	{
		$text = $this->_rootElement->find('#block-product-list > div > div > div > div > div:nth-child(1) > div > div.product-info > div > span')->getText();
		return substr($text, 1);
	}

	public function getFirstProductOutOfStockIcon()
	{
		return $this->_rootElement->find('#block-product-list > div > div > div > div > div:nth-child(1) > div > div.product-img > a > span');
	}

	// Click the first product in the checkout page
	public function clickFirstProduct()
	{
		$this->_rootElement->find('.product-item .product-img')->click();
	}

	// Set value to input search for adding product to cart
	public function search($string)
	{
		$this->_rootElement->find('#search-header-product')->setValue($string);
	}

	public function getProductList()
	{
		return $this->_rootElement->find('#block-product-list');
	}

	public function getCustomSaleButton()
	{
		return $this->_rootElement->find('.custom-sale');
	}

	public function waitProductListToLoad()
	{
		$this->waitForElementNotVisible('#product-list-overlay > span.product-loader');
	}
}