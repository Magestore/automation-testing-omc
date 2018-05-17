<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/14/2018
 * Time: 8:47 AM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Pos\Edit;

use Magento\Mtf\Client\Locator;

class FormPageActions extends  \Magento\Backend\Test\Block\FormPageActions
{
    protected $saveAndContinueButton = '#saveandcontinue';

    public function getResetButton() {
        return $this->_rootElement->find('#reset');
    }

    public function getSaveAndContinueButton() {
        return $this->_rootElement->find('#saveandcontinue');
    }

    public function getLockButton() {
        return $this->_rootElement->find('#lock');
    }

    public function getUnlockButton() {
        return $this->_rootElement->find('#unlock');
    }

    public function getButtonByname($name)
    {
            return $this->_rootElement->find('//div[@class="page-actions-buttons"]//button//span[text()="' . $name . '"]', Locator::SELECTOR_XPATH);
    }

    public function getTitle()
    {
        return $this->_rootElement->find('//h1[@class="page-title"]', Locator::SELECTOR_XPATH);
    }
}