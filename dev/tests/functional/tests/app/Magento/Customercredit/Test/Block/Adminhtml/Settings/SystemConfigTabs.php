<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/29/2017
 * Time: 9:13 AM
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\Settings;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class SystemConfigTabs extends Block
{
    protected $configItem = '//*[@id="system_config_tabs"]/div/ul/li[contains(@class, "_active")]';

    protected $configItemName = '//span[text()="%s"]';

    public function getConfigItem($configItem)
    {
        return $this->_rootElement->find($this->configItem, Locator::SELECTOR_XPATH)
            ->find(sprintf($this->configItemName, $configItem), Locator::SELECTOR_XPATH);
    }

}