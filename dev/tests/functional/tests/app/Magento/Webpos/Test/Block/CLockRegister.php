<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 23/05/2018
 * Time: 13:58
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class CLockRegister
 * @package Magento\Webpos\Test\Block
 */
class CLockRegister extends Block
{
    public function getLockRegisterPopup()
    {
        return $this->_rootElement->find('.lock-register');
    }

    public function getInputLockRegisterPin($index)
    {
        return $this->_rootElement->find('//*[@class="block-pin"]/input[@class="lock-register-pin"]['.$index.']', Locator::SELECTOR_XPATH);
    }

    public function getButtonCancel()
    {
        return $this->_rootElement->find('.close');
    }

    public function getLockIcon()
    {
        return $this->_rootElement->find('.icon-lockPOS-modal');
    }

    public function getLockText()
    {
        return $this->_rootElement->find('//div[text()="Please enter security PIN to lock the register"]', Locator::SELECTOR_XPATH);
    }

    public function waitForPopupLockRegister()
    {
        $this->waitForElementVisible('.lock-register');
    }

    public function waitForPopupLockRegisterNotVisible()
    {
        $this->waitForElementNotVisible('.lock-register');
    }
}