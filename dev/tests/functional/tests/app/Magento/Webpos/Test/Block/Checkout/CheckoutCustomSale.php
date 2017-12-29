<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:09
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class CheckoutCustomSale
 * @package Magento\Webpos\Test\Block\CategoryRepository
 */
class CheckoutCustomSale extends Block
{

	public function getCancelButton()
	{
		return $this->_rootElement->find('button.remove');
	}

	public function getProductNameInput()
	{
		return $this->_rootElement->find('input[name="name-product"]');
	}

	public function getDescriptionInput()
	{
		return $this->_rootElement->find('textarea[name="comment-product"]');
	}

	public function getProductPriceInput()
	{
		return $this->_rootElement->find('.product-price');
	}

	public function getShipAbleCheckbox()
	{
//		return $this->getPopupCustomSale()->find('#popup-custom-sale > div.modal-body > div > div:nth-child(2) > div > div > div');
		return $this->_rootElement->find('.switch-box');
	}

	public function getAddToCartButton()
	{
		return $this->_rootElement->find('#popup-custom-sale > div.modal-body > div > div.ms-actions > button');
	}

	public function clickSelectTaxClass()
	{
		$this->_rootElement->find('.selectpicker')->click();
	}

	public function getTaxClassItem($name)
	{
		return $this->_rootElement->find('//*[@id="popup-custom-sale"]/div[2]/div/div[1]/div[3]/div/select/option[text()="'.$name.'"]', Locator::SELECTOR_XPATH);
	}
}