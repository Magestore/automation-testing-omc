<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:09
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\ElementInterface;

/**
 * Class CheckoutPlaceOrder
 * @package Magento\Webpos\Test\Block\CategoryRepository
 */
class CheckoutPlaceOrder extends Block
{
    /**
     * @return bool|null
     */
    public function waitShippingSection()
    {
        $this->waitForElementVisible('#checkout-method > div:nth-child(1)');
    }
    public function waitPaymentSection()
    {
        $this->waitForElementVisible('#checkout-method > div:nth-child(2)');
    }

    public function waitCartLoader()
    {
        $this->waitForElementNotVisible('.indicator');
    }

    public function getTopTotalPrice()
    {
        return $this->_rootElement->find('#webpos_checkout > header > div > span');
    }

    public function getRemainMoney()
    {
        return $this->_rootElement->find('.remain-money');
    }

    public function getButtonAddPayment()
    {
        return $this->_rootElement->find('#add_payment_button');
    }

    public function getButtonPlaceOrder()
    {
        return $this->_rootElement->find('#checkout_button');
    }

	/**
	 * @param ElementInterface $divCheckbox
	 * @return bool|int
	 */
	public function isCheckboxChecked($divCheckbox)
	{
		$class = $divCheckbox->find('div')->getAttribute('class');
		return strpos($class, 'checked');
	}

	public function getCreateInvoiceCheckbox()
	{
		return $this->_rootElement->find('#can_paid');
	}

	public function getShippingCheckbox()
	{
		return $this->_rootElement->find('#can_ship');
	}
}