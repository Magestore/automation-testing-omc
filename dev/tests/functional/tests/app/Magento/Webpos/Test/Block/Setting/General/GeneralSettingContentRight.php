<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 15:21
 */

namespace Magento\Webpos\Test\Block\Setting\General;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
/**
 * Class GeneralSettingContentRight
 * @package Magento\Webpos\Test\Block\Setting\General
 */
class GeneralSettingContentRight extends Block
{
    /**
     * Begin Checkout Menu Tab Page
     */
    public function getUseOnlineModeSelection()
    {
        return $this->_rootElement->find('#os_checkout\2e enable_online_mode');
    }

    public function getAutoCheckPromotionSelection()
    {
        return $this->_rootElement->find('#os_checkout\2e auto_check_promotion_rules');
    }
    public function selectAutoCheckPromotionOption($option)
    {
        $this->getAutoCheckPromotionSelection()->click();
        return $this->_rootElement->find('//*[@id="os_checkout.auto_check_promotion_rules"]/option[text()="' . $option . '"]', Locator::SELECTOR_XPATH);
    }

    public function getSyncOnHoldOrderToServerSelection()
    {
        return $this->_rootElement->find('#os_checkout\2e sync_order_onhold');
    }
    public function selectSyncOnHoldOrderOption($option)
    {
        $this->getSyncOnHoldOrderToServerSelection()->click();
        return $this->_rootElement->find('//*[@id="os_checkout.sync_order_onhold"]/option[text()="' . $option . '"]', Locator::SELECTOR_XPATH);
    }

    /**
     * Begin Catalog Menu Tab Page
     */
    public function getDisplayOutOfStockSelection()
    {
        return $this->_rootElement->find('#outstock-display');
    }

    public function selectDisplayOption($option)
    {
        $this->getDisplayOutOfStockSelection()->click();
        return $this->_rootElement->find('//*[@id="outstock-display"]/option[text()="' . $option . '"]', Locator::SELECTOR_XPATH);
    }

    /**
     * Begin Currency Menu Tab Page
     */
    public function getCurrencySelection()
    {
        return $this->_rootElement->find('#currency');
    }

    /**
     * Begin POS Hub Menu Tab Page
     */
    public function getServerIPAddress()
    {
        return $this->_rootElement->find('#server_ip_address');
    }
    public function getEnableOpenCashSelection()
    {
        return $this->_rootElement->find('#hardware\2e cashdrawer-manual');
    }
    public function getCashDrawerKickInput()
    {
        return $this->_rootElement->find('#cashdrawer_code');
    }
    public function getPrintViaPOSHubSelection()
    {
        return $this->_rootElement->find('#hardware\2e printer');
    }
    public function getEnablePoleDisplaySelection()
    {
        return $this->_rootElement->find('#hardware\2e pole');
    }
}