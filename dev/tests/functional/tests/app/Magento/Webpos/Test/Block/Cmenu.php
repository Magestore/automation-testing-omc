<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-15 12:53:06
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 09:34:58
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class Cmenu extends Block
{
    public function logout()
    {
        $this->_rootElement->find('.logout-box')->click();
    }

    public function checkout()
    {
        $this->_rootElement->find('#checkout')->click();
    }

    public function ordersHistory()
    {
        $this->_rootElement->find('#orders_history')->click();
    }

    public function onHoldOrders()
    {
        $this->_rootElement->find('#on_hold_orders')->click();
    }

    public function getSessionManagement()
    {
        $this->_rootElement->find('#item_register_shift')->click();
    }

    public function manageStocks()
    {
        $this->_rootElement->find('#manage_stock')->click();
    }

    public function manageStocksIsVisible()
    {
        return $this->_rootElement->find('#manage_stock')->isVisible();
    }

    public function synchronization()
    {
        $this->_rootElement->find('#synchronization')->click();
    }

    public function account()
    {
        $this->_rootElement->find('#account')->click();
    }

    public function general()
    {
        $this->_rootElement->find('#general')->click();
    }

    public function getUsername()
    {
        return $this->_rootElement->find('.admin-name')->getText();
    }

    public function registerShift()
    {
        $this->_rootElement->find('#register_shift')->click();
    }

    public function customerList()
    {
        $this->_rootElement->find('#customer_list')->click();
    }

    public function ordersMenuIsVisible()
    {
        return $this->_rootElement->find('.//ul[@class="c-menu__items" and .//li[@id="group_order"]]', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function sessionManagementMenuIsVisible()
    {
        return $this->_rootElement->find('.//ul[@class="c-menu__items" and .//li[@id="group_shift"]]', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function customersMenuIsVisible()
    {
        return $this->_rootElement->find('.//ul[@class="c-menu__items" and .//li[@id="group_customer"]]', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function settingsMenuIsVisible()
    {
        return $this->_rootElement->find('.//ul[@class="c-menu__items" and .//li[@id="group_setting"]]', Locator::SELECTOR_XPATH)->isVisible();
    }
}
