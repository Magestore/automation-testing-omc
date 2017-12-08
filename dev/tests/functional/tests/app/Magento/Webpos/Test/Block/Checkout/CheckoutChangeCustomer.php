<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/12/2017
 * Time: 08:10
 */

namespace Magento\Webpos\Test\Block\Checkout;


use Magento\Mtf\Block\Block;

class CheckoutChangeCustomer extends Block
{
	public function getAddNewCustomerButton()
	{
		return $this->_rootElement->find('#btn-add-new-customer');
	}

	public function getUseGuestButton()
	{
		return $this->_rootElement->find('a.btn-use-guest');
	}

	public function search($text)
	{
		$this->waitForCustomerList();
		$this->_rootElement->find('#search-customer')->setValue($text);
		$this->waitForCustomerList();
		sleep(2);
	}

	public function getFirstCustomer()
	{
		return $this->_rootElement->find('ul.list-customer-old > li:nth-child(1)');
	}

	public function waitForCustomerList()
	{
		$this->waitForElementVisible('.list-customer-old');
	}
}