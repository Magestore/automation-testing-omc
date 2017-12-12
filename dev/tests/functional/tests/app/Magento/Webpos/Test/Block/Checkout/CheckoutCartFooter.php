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
 * Class CheckoutCartFooter
 * @package Magento\Webpos\Test\Block\Checkout
 */
class CheckoutCartFooter extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     * get The Buttons
     */
    public function getButtonHold()
    {
        return $this->_rootElement->find('.hold');
    }
    public function getButtonCheckout()
    {
        return $this->_rootElement->find('.checkout');
    }
    // Get Grand Total Item price value
    public function getGrandTotalItemPrice($label)
    {
        return $this->_rootElement->find('//*[@id="webpos_cart"]/div/div/div/ul/li/div[1]/label[text()="'.$label.'"]/../../div[2]/span', Locator::SELECTOR_XPATH);
    }

	public function getAddDiscount()
	{
		return $this->_rootElement->find('//div/ul/li/div[contains(@class, "add-discount")]/..', Locator::SELECTOR_XPATH);
	}
}