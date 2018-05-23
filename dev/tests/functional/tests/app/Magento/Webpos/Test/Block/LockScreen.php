<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 23/05/2018
 * Time: 14:07
 */

namespace Magento\Webpos\Test\Block;


use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class LockScreen extends Block
{
    public function getInputUnLockRegisterPin($index)
    {
        return $this->_rootElement->find('//*[@class="block-pin"]/input[@class="lock-screen-pin"]['.$index.']', Locator::SELECTOR_XPATH);
    }
}