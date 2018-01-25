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

	public function isDisplayPopup()
    {
        return $this->_rootElement->isVisible();
    }

	public function getDollarButton()
	{
		return $this->_rootElement->find('#btn-dollor3');
	}

	public function getDiscountButton()
	{
		return $this->_rootElement->find('#btn-percent3');
	}

	/**
	 * @param $amount
	 * Ex: 80.00 , 100.00, 90.50 ...
	 */
	public function setDiscountAmount($amount)
	{
		$amount = str_replace('.', '', $amount);
		for ($i = 0; $i < strlen($amount); $i++) {
			$this->clickNumberButton($amount[$i]);
		}
	}

    public function setNumberDiscount($number)
    {
        $numbers = explode('.',$number);
        foreach ($numbers as $number)
        {
            if (floatval($number) >= 100.0)
                break;
            if (floatval($number) >= 10)
            {
                $a = (int)($number / 10);
                $b = (int)($number - $a*10);
                $this->clickNumberButton((string)$a);
                $this->clickNumberButton((string)$b);
            }else
                $this->clickNumberButton($number);

        }
    }

    public function setTypeDiscount($type)
    {
        if ($type == '%')
            $this->_rootElement->find('#btn-percent3')->click();
        if ($type == '$')
            $this->_rootElement->find('#btn-dollor3')->click();
    }

    public function clickDiscountButton()
    {
        $this->_rootElement->find('button[class="custom-price"]')->click();
    }

    public function clickPromotionButton()
    {
        $this->_rootElement->find('button[class="discount"]')->click();
    }

    public function setCouponCode($number)
    {
        $this->_rootElement->find('input[name="coupon_code"]')->setValue($number);

    }
}