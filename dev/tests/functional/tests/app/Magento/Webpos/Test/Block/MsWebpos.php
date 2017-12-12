<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-15 12:41:49
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-15 12:42:21
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
/**
 * Class MsWebpos
 * @package Magento\Webpos\Test\Block
 */
class MsWebpos extends Block
{
	public function clickCMenuButton()
	{
		$this->_rootElement->find('#c-button--push-left')->click();
	}

	public function getLoader()
	{
		return $this->_rootElement->find('#checkout-loader');
	}

	public function getHide()
    {
        return $this->_rootElement->find('#c-mask');
    }

	public function waitCartLoader()
	{
		$this->waitForElementNotVisible('#webpos_cart > div.indicator');
	}

	public function waitCheckoutLoader()
	{
		$this->waitForElementNotVisible('#webpos_checkout > div.indicator');
	}
}
