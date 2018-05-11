<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 15:20
 */

namespace Magento\Webpos\Test\Block\Setting\General;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
/**
 * Class GeneralSettingMenuLMainItem
 * @package Magento\Webpos\Test\Block\Setting\General
 */
class GeneralSettingMenuLMainItem extends Block
{
    public function getMenuItem($label)
    {
        return $this->_rootElement->find('//li/a[text()="'.$label.'"]', Locator::SELECTOR_XPATH);
    }
}