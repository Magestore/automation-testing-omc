<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 11/01/2018
 * Time: 16:09
 */
namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
/**
 * Class CheckoutContainer
 * @package Magento\Webpos\Test\Block
 */
class CheckoutContainer extends Block
{
    public function getStyleLeft()
    {
        $styleLeft = $this->_rootElement->getAttribute('style');
        $styleLeft = str_replace('left: ', '', $styleLeft);
        $styleLeft = (float)str_replace('px;', '', $styleLeft);
        return $styleLeft;
    }

	public function waitForProductEditPopop()
	{
		$this->waitForElementVisible('#popup-edit-product');
	}

	public function waitForProductDetailPopup()
	{
		$this->waitForElementVisible('#popup-product-detail');
	}

	public function waitForCustomSalePopup()
	{
		$this->waitForElementVisible('#popup-custom-sale');
	}

	public function waitForCartDiscountPopup()
	{
		$this->waitForElementVisible('#webpos_cart_discountpopup');
	}

	public function waitForAddMorePaymentModal()
	{
		$this->waitForElementVisible('#add-more-payment');
	}

	public function clickOutSide() {
        return $this->_rootElement->find('#checkout_container > div.wrap-backover.hide-popup');
    }
}