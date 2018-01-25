<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/12/2017
 * Time: 08:42
 */

namespace Magento\Webpos\Test\Block\Checkout;


use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class CheckoutAddCustomer extends Block
{
	public function getCancelButton()
	{
		return $this->_rootElement->find('.close');
	}

	public function getSaveButton()
	{
		return $this->_rootElement->find('.btn-save');
	}

	public function getFirstNameInput()
	{
		return $this->_rootElement->find('input[name="first-name"]');
	}

	public function getLastNameInput()
	{
		return $this->_rootElement->find('input[name="last-name"]');
	}

	public function getEmailInput()
	{
		return $this->_rootElement->find('input[name="email"]');
	}

	public function clickGroupSelect()
	{
		$this->_rootElement->find('#customer_group')->click();
		sleep(1);
	}

	public function getCustomerGroupItem($name)
	{
		$selector = '//select[contains(@data-bind, "value: groupCustomer")]/option[text()="%s"]';
		return $this->_rootElement->find(sprintf($selector, $name), Locator::SELECTOR_XPATH);
	}

	public function getAddShippingAddressIcon()
	{
		return $this->_rootElement->find('span[data-bind="click: showShippingAddress, visible: !isShowShippingSummaryForm()"]');
	}

	public function setFieldWithoutShippingAndBilling($customer)
    {
        foreach ($customer as $item => $value){
            switch ($item)
            {
                case 'firstname' :
                    $this->_rootElement->find('input[name="first-name"]')->setValue($value);
                    break;

                case 'lastname' :
                    $this->_rootElement->find('input[name="last-name"]')->setValue($value);
                    break;

                case 'email' :
                    $this->_rootElement->find('input[name="email"]')->setValue($value);
                    break;

                case 'group_id' :
                    $this->_rootElement->find('#customer_group', Locator::SELECTOR_CSS, 'select')->setValue($value);
                    break;

            }
        }
    }
}