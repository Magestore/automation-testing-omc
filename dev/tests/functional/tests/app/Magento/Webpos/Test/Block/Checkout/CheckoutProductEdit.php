<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:22
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
/**
 * Class CheckoutProductEdit
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\CategoryRepository
 */
class CheckoutProductEdit extends Block
{
	public function getCancelButton()
	{
		return $this->_rootElement->find('.hide-popup-custom-sale');
	}

	public function getProductName()
	{
		return $this->_rootElement->find('.product-name');
	}

	public function getProductImage()
	{
		return $this->_rootElement->find('.product-img');
	}

	public function getQtyInput()
	{
		return $this->_rootElement->find('#editpopup_product_qty');
	}

	public function getDescQtyButton()
	{
		return $this->_rootElement->find('#bt_desc_qty');
	}

	public function getIncQtyButton()
	{
		return $this->_rootElement->find('#bt_inc_qty');
	}

	public function waitCustomPriceButton()
	{
        $customPrice = $this->_rootElement->find('.custom-price');
		if(!$customPrice->isVisible()) {
            $browser = $this->_rootElement;
            $browser->waitUntil(
                function () use ($customPrice) {
                    return $customPrice->isVisible() ? true : null;
                }
            );
        }
	}
	public function getCustomPriceButton()
	{
	    $this->waitCustomPriceButton();
		return $this->_rootElement->find('.custom-price');
	}

	public function getDiscountButton()
	{
		return $this->_rootElement->find('.discount');
	}

	public function waitDiscountButton()
	{
        $discount = $this->_rootElement->find('.discount');
        $browser = $this->_rootElement;
        $browser->waitUntil(
            function () use ($discount) {
                return $discount->isVisible() ? true : null;
            }
        );
	}

	public function waitForDiscountButtonVisible()
	{
		return $this->waitForElementVisible('.discount');
	}

	public function getAmountInput()
	{
		return $this->_rootElement->find('div.price-box > input');
	}

	public function getActiveButton() {
	    return $this->_rootElement->find('div.price-box .btn-cl-cfg-active');
    }

	public function getDollarButton()
	{
		return $this->_rootElement->find('#btn-dollor');
	}

	public function getPercentButton()
	{
		return $this->_rootElement->find('#btn-percent');
	}

	public function getPanelPriceBox()
    {
        return $this->_rootElement->find('[class="price-box"]');
    }

    public function getPanelDiscount()
    {
        return $this->_rootElement->find('.discount');
    }
}