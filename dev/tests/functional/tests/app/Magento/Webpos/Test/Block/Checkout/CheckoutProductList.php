<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:05
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class CheckoutProductList
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\CategoryRepository
 */
class CheckoutProductList extends Block
{
    // Set value to input search for adding product to cart
    public function search($string)
    {
        $this->_rootElement->find('#search-header-product')->setValue($string);
    }
    public function getFirstProduct()
    {
        return $this->_rootElement->find('.product-item');
    }

    public function getFirstProductImage()
    {
        return $this->_rootElement->find('//*[@id="block-product-list"]/div/div/div/div/div[1]/div/div[@class="product-img"]/img', Locator::SELECTOR_XPATH);
    }

    public function getFirstProductName()
    {
        return $this->_rootElement->find('//*[@id="block-product-list"]/div/div/div/div/div[1]/div/div[@class="product-info"]/h3[@class="product-name"]', Locator::SELECTOR_XPATH);
    }

    public function getFirstProductQty()
    {
        return $this->_rootElement->find('//*[@id="block-product-list"]/div/div/div/div/div[1]/div/div[@class="product-info"]/label[@class="available_qty"]', Locator::SELECTOR_XPATH);
    }

    public function getFirstProductDetailButtonHover()
    {
        $this->_rootElement->find('//*[@id="block-product-list"]/div/div/div/div/div[1]/div/a',Locator::SELECTOR_XPATH)->hover();
    }

    public function getFirstProductDetailButton()
    {
        return $this->_rootElement->find('//*[@id="block-product-list"]/div/div/div/div/div[1]/div/a/span', Locator::SELECTOR_XPATH);
    }

    public function getFirstProductPrice()
    {
        $text = $this->_rootElement->find('#block-product-list > div > div > div > div > div:nth-child(1) > div > div.product-info > div > span')->getText();
        return substr($text, 1);
    }

    public function getFirstProductRegularPrice()
    {
        return $this->_rootElement->find('//*[@id="block-product-list"]/div/div/div/div/div[1]/div/div[@class="product-info"]/div/span[@class="regular-price price"]', Locator::SELECTOR_XPATH);
    }

    public function getFirstProductFinalPrice()
    {
        return $this->_rootElement->find('//*[@id="block-product-list"]/div/div/div/div/div[1]/div/div[@class="product-info"]/div/span[@class="final-price price"]', Locator::SELECTOR_XPATH);
    }

    public function getFirstProductOutOfStockIcon()
    {
        return $this->_rootElement->find('#block-product-list > div > div > div > div > div:nth-child(1) > div > div.product-img > a > span');
    }

    public function getProductList()
    {
        return $this->_rootElement->find('#block-product-list');
    }

    public function waitProductList()
    {
        $this->waitForElementVisible('#block-product-list');
    }

    public function getCustomSaleButton()
    {
        return $this->_rootElement->find('.custom-sale');
    }

    public function waitProductListToLoad()
    {
        $this->waitForElementNotVisible('#product-list-overlay > span.product-loader');
    }
    public function waitProductListVisibleToNotVisible()
    {
        $this->waitForElementVisible('#product-list-overlay > span.product-loader');
        $this->waitForElementNotVisible('#product-list-overlay > span.product-loader');
    }

    public function getSearchInput()
    {
        return $this->_rootElement->find('#search-header-product');
    }

    public function getCategoryButton()
    {
        return $this->_rootElement->find('div[data-bind="click: getAllCategories"]');
    }

    public function getNumberOfProducts()
    {
        return $this->_rootElement->find('label[data-bind="text: total.call() + \' product(s)\'"]');
    }

    public function getPageNumber()
    {
        return $this->_rootElement->find('//*[@id="productPager"]/ul/li/span[@class="pager"]', Locator::SELECTOR_XPATH);
    }

    public function getProductNameSearch($productName)
    {
        return $this->_rootElement->find('//*[@id="product1"]/div[2]/h3[text()='.$productName.']', Locator::SELECTOR_XPATH);
    }
}