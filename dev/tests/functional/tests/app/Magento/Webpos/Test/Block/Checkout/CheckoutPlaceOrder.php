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

    public function isCheckoutButtonVisible(){
        return $this->_rootElement->find('#checkout_button')->isVisible();
    }

	/**
	 * @param ElementInterface $divCheckbox
	 * @return bool|int
	 */
	public function isCheckboxChecked($divCheckbox)
	{
		$class = $divCheckbox->find('.ios-ui-select')->getAttribute('class');
		return strpos($class, 'checked');
	}

	public function getCreateInvoiceCheckbox()
	{
		return $this->_rootElement->find('#can_paid');
	}

	public function waitForCreateInvoiceCheckboxVisible()
	{
	    $this->waitForElementVisible('#can_paid');
	}

	public function getShippingCheckbox()
	{
		return $this->_rootElement->find('#can_ship');
	}

	public function waitForShippingCheckboxVisible()
	{
		 $this->waitForElementVisible('#can_ship');
	}

	public function isShippingMethod(){
	         return $this->_rootElement->find('[name="shipping_method"]')->isPresent();
	}

    public function isSelectedShippingMethod($shippingMethod){
        return $this->_rootElement->find('#'.$shippingMethod)->isSelected();
    }
    public function getTitleShippingSection(){
        return $this->_rootElement->find('#checkout-method > div:nth-child(1) > div.panel-heading > h4 > a')->getText();
    }
    public function getShippingCollapse(){
        return $this->_rootElement->find('#checkout-method > div:nth-child(1) > div.panel-heading > h4 > a');
    }
    public function isMethodVisible($idShippingMethod){

        return $this->_rootElement->find('#'.$idShippingMethod)->isPresent();
    }
    public function isPanelShippingMethod(){

        return $this->_rootElement->find('#checkout-method > div:nth-child(1) > div.panel-heading > h4 > a')->isVisible();
    }
	public function getMessageAddMorePayment()
    {
        return $this->_rootElement->find('.//div[data-bind="visible: checkPaymentCollection()"] > span ');
    }

    public function getAddPaymentDisable()
    {
        return $this->_rootElement->find('button[id="add_payment_button"][disabled]');
    }

    public function getHeaderAmount()
    {
        return $this->_rootElement->find('.//*[@id="webpos_checkout"]//span[@class="price"]', Locator::SELECTOR_XPATH);
    }

    public function getRemainMoneyPrice()
    {
        return $this->_rootElement->find('.remain-money > span');
    }

    public function getInvoiceBox()
    {
        return $this->_rootElement->find('.invoice-box');
    }

    public function isActivePageCheckout(){
        return (strpos($this->_rootElement->getAttribute('class'),'active')!== false ? true : false);
    }
}