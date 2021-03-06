<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-15 12:41:49
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-15 12:42:21
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;

/**
 * Class MsWebpos
 * @package Magento\Webpos\Test\Block
 */
class MsWebpos extends Block
{
    public function clickCMenuButton()
    {
        $this->_rootElement->find('#c-button--push-left')->click();
    }

    public function waitForCMenuButton()
    {
        $cMenu = $this->_rootElement->find('#c-button--push-left');
        if (!$cMenu->isVisible()) {
            $this->waitForElementVisible('#c-button--push-left');
        }
    }

    public function getCMenuButton()
    {
        return $this->_rootElement->find('#c-button--push-left');
    }

    public function getLoader()
    {
        return $this->_rootElement->find('#checkout-loader');
    }

    public function getHide()
    {
        return $this->_rootElement->find('#c-mask');
    }

    public function getCartLoader()
    {
        return $this->_rootElement->find('#webpos_cart > div.indicator');
    }

    public function waitCartLoader()
    {
        $this->waitForElementNotVisible('#webpos_cart > div.indicator');
    }

    public function waitCartLoaderVisibleToNotVisible()
    {
        $this->waitForElementVisible('#webpos_cart > div.indicator');
        $this->waitForElementNotVisible('#webpos_cart > div.indicator');
    }

    public function waitCheckoutLoader()
    {
        $this->waitForElementNotVisible('#webpos_checkout > div.indicator');
    }

    public function waitForSyncDataAfterLogin()
    {
        $this->waitForElementVisible('#block-webpos-install .first-screen');
        $this->waitForElementNotVisible('#block-webpos-install .first-screen');
    }

    public function waitForSyncDataVisible()
    {
        $this->waitForElementVisible('#block-webpos-install .first-screen');
    }

    public function waitForModalPopup()
    {
        $this->waitForElementVisible('.modals-wrapper');
    }

    public function waitForModalPopupNotVisible()
    {
        $this->waitForElementNotVisible('.modals-wrapper');
    }

    public function waitOrdersHistoryVisible()
    {
        $this->waitForElementVisible('#orders_history_container');
    }

    public function waitListOrdersHistoryVisible()
    {
        $this->waitForElementVisible('.list-orders');
    }

    public function cmenuButtonIsVisible()
    {
        return $this->_rootElement->find('#c-button--push-left')->isVisible();
    }

    public function getProductDetailPopup()
    {
        return $this->_rootElement->find('#popup-product-detail');
    }

    public function waitForCMenuLoader()
    {
        $this->waitForElementVisible('#c-menu--push-left');
    }

    public function waitForSessionManagerLoader()
    {
        $this->waitForElementVisible('#register_shift_container #shift_container');
    }

    public function getOpenShipPopup()
    {
        return $this->_rootElement->find('#popup-open-shift');
    }

    public function waitForCMenuVisible()
    {
        $this->waitForElementVisible('#c-button--push-left');
    }

    public function waitForLockScreen()
    {
        $this->waitForElementVisible('.first-screen.lock-screen');
    }

    public function waitForCheckoutLoaderNotVisible()
    {
        $this->waitForElementNotVisible('#checkout-loader.loading-mask');
    }
}
