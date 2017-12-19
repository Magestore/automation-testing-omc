<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:06
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class CheckoutCartHeader
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\Checkout
 */
class CheckoutCartHeader extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     * get Icon Delete Cart
     */
    public function getIconDeleteCart()
    {
        return $this->_rootElement->find('#empty_cart');
    }
    public function getIconActionMenu()
    {
        return $this->_rootElement->find('.icon-iconPOS-more');
    }
    public function getAddMultiOrder()
    {
        return $this->_rootElement->find('span.order-button.pull-right');
    }
    public function getAnyOrderItem()
    {
        return $this->_rootElement->find('.order-sequence');
    }
    public function getTimeOrder()
    {
       return $this->_rootElement->find('data-bind="click: $parents[0].processItem.bind($parents[0])"');
    }
    public function getIconAddCustomer()
    {
        return $this->_rootElement->find('.icon-iconPOS-change-customer');
    }
    public function getCustomerTitleDefault()
    {
        return $this->_rootElement->find('.add-customer > .title-header-page');
    }

	public function getMultiOrderItem($number)
	{
		return $this->_rootElement->find('//div[contains(@class, "order-selector")]/span/span/span[text()= "'.$number.'"]/..', Locator::SELECTOR_XPATH);
	}
}