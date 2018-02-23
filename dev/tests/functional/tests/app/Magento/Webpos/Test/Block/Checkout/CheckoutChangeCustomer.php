<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/12/2017
 * Time: 08:10
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
/**
 * Class CheckoutChangeCustomer
 * @package Magento\Webpos\Test\Block\CategoryRepository
 */
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
		$this->_rootElement->find('.icon-iconPOS-search')->click();
		$this->waitForCustomerList();
	}

	public function getFirstCustomer()
	{
//		$this->waitForCustomerList();
//		$this->_rootElement->click();
//		$this->waitForCustomerList();
		return $this->_rootElement->find('ul.list-customer-old > li:nth-child(1)');
	}

	public function getFirstCustomerName()
    {
        return $this->getFirstCustomer()->find('a');
    }

	public function getFirstCustomerPhone()
	{
		return $this->getFirstCustomer()->find('.phone-number');
	}

	public function waitForCustomerList()
	{
//		sleep(1);
		$this->waitForElementNotVisible('#customer-overlay');
	}

    public function getCustomerResult()
    {
        return $this->_rootElement->find('.list-customer-old a');
    }

	public function getSearchBox()
	{
		return $this->_rootElement->find('#search-customer');
	}
}