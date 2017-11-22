<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/11/2017
 * Time: 09:33
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
/**
 * Class AddCustomerOnCheckout
 * @package Magento\Webpos\Test\Block
 */
class AddCustomerOnCheckout extends Block
{
    public function getCustomerFirstName()
    {
        return $this->_rootElement->find('.customer-fname');
    }
    public function getCustomerLastName()
    {
        return $this->_rootElement->find('.customer-lname');
    }
    public function getCustomerEmail()
    {
        return $this->_rootElement->find('.customer-email');
    }
    public function getCustomerGroup()
    {
        return $this->_rootElement->find('#customer_group');
    }
    public function getCustomerOption($group)
    {
        $this->getCustomerGroup()->click();
        return $this->_rootElement->find('//*[@id="form-customer-add-customer-checkout"]/div/div/div[2]/div/div[1]/div[4]/div/select/option[text()="'.$group.'"]',  Locator::SELECTOR_XPATH);
    }
    public function getCustomerSwitchBox()
    {
        return $this->_rootElement->find('.switch-box');
    }
    public function getAddShippingAddress()
    {
        return $this->_rootElement->find('.shipping-title .icon-iconPOS-add');
    }
    public function getAddBillingAddress()
    {
        return $this->_rootElement->find('.billing-title .icon-iconPOS-add');
    }
    public function getSaveCustomer()
    {
        return $this->_rootElement->find('button[data-bind="click: saveCustomerForm, i18n:\'Save\'"');
    }
    public function getFirstNameError()
    {
        return $this->_rootElement->find('#first-name-error');
    }
    public function getLastNameError()
    {
        return $this->_rootElement->find('#last-name-error');
    }
    public function getEmailError()
    {
        return $this->_rootElement->find('#email-error');
    }
    public function getCustomerGroupError()
    {
        return $this->_rootElement->find('#customer_group-error');
    }
}