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
 * @package Magento\Webpos\Test\Block\CategoryRepository
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

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getButtonCheckout()
    {
        return $this->_rootElement->find('.checkout');
    }
    // Get Grand Total Item price value

    /**
     * @param $label
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getGrandTotalItemPrice($label)
    {
        return $this->_rootElement->find('//*[@id="webpos_cart"]/div/div/div/ul/li/div[1]/label[text()="'.$label.'"]/../../div[2]/span', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getAddDiscount()
	{
		return $this->_rootElement->find('//div/ul/li/div[contains(@class, "add-discount")]/..', Locator::SELECTOR_XPATH);
	}

	public function getDiscount()
	{
		return $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Discount"]/../..', Locator::SELECTOR_XPATH);
	}

	public function waitButtonHoldVisible()
	{
		$this->waitForElementVisible('.hold');
	}

    public function isAddDiscountVisible()
    {
        return $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Add Discount"]/../..', Locator::SELECTOR_XPATH)->isVisible();
    }
    public function isDiscountVisible()
    {
        return $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Discount"]/../..', Locator::SELECTOR_XPATH)->isVisible();
    }
    public function getTaxWithCheckout()
    {
        $value = $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Tax"]/../../div[2]/span', Locator::SELECTOR_XPATH)->getText();
        return floatval(str_replace('$', '',$value));
    }
    public function getShippingPrice()
    {
        $value = $this->_rootElement->find('//div/ul/li/div[1]/label[text()="Shipping"]/../../div[2]/span', Locator::SELECTOR_XPATH)->getText();
        return floatval(str_replace('$', '',$value));
    }
}