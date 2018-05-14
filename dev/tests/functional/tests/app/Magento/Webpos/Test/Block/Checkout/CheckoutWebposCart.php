<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/12/2017
 * Time: 11:20
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
/**
 * Class CheckoutWebposCart
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\CategoryRepository
 */
class CheckoutWebposCart extends Block
{
    public function getOrderSequence($value)
    {
        return $this->_rootElement->find('//*[@id="webpos_cart"]/header/div[1]/span[2]/span[1]/span[text()='.$value.']', Locator::SELECTOR_XPATH);
    }

    public function getIconChangeCustomer()
    {
        return $this->_rootElement->find('.icon-iconPOS-change-customer');
    }

    public function getCustomerTitleHeaderPage()
    {
        return $this->_rootElement->find('.actions-customer .title-header-page');
    }

    public function getIconPrevious()
    {
        return $this->_rootElement->find('.icon-iconPOS-previous');
    }

    public function getPriceShipping()
    {
        $value = $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Shipping"]/../../div[2]/span', Locator::SELECTOR_XPATH)->getText();
        return floatval(str_replace('$', '',$value));
    }

    public function getSubtotal()
    {
        $value = $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Subtotal"]/../../div[2]/span', Locator::SELECTOR_XPATH)->getText();
        return floatval(str_replace('$', '',$value));
    }

    public function getTotal()
    {
        $value = $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Total"]/../../div[2]/span', Locator::SELECTOR_XPATH)->getText();
        return floatval(str_replace('$', '',$value));
    }

    public function getTax()
    {
        $value = $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Tax"]/../../div[2]/span', Locator::SELECTOR_XPATH)->getText();
        return floatval(str_replace('$', '',$value));
    }

    public function isDisplayShippingOnCart()
    {
        return $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Shipping"]/../..', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function waitForDisplayShippingOnCart()
    {
        $isDisplayShippingOnCart = $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Shipping"]/../..', Locator::SELECTOR_XPATH);
        $browser = $this->_rootElement;
        $browser->waitUntil(
            function () use ($isDisplayShippingOnCart) {
                return $isDisplayShippingOnCart->isVisible() ? true : null;
            }
        );
    }

    public function waitLoading()
    {
        $this->waitForElementNotVisible('iv.indicator');
    }

    public function getIconRemoveMultiOrder($number)
    {
        return $this->_rootElement->find('.//header/div[1]/span[2]/span[2]', Locator::SELECTOR_XPATH);
    }
}