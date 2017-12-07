<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/12/2017
 * Time: 13:24
 */

namespace Magento\Webpos\Test\Block\Checkout;


use Magento\Mtf\Block\Block;

class CheckoutDiscount extends Block
{
	public function clickDiscountApplyButton()
	{
		$this->_rootElement->find('.btn-apply')->click();
	}

	public function clickNumberButton($value)
	{
		$this->_rootElement->find('button[value="' . $value . '"]')->click();
	}


	/**
	 * @param $percent
	 * Ex: 80.00 , 100.00, 90.50 ...
	 */
	public function setDiscountPercent($percent)
	{
		$this->_rootElement->find('#btn-percent3')->click();
		$percent = str_replace('.', '', $percent);
		for ($i = 0; $i < strlen($percent); $i++) {
			$this->clickNumberButton($percent[$i]);
		}
	}
}