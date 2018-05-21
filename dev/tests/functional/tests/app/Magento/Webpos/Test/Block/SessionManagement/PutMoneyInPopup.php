<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/9/2018
 * Time: 8:48 AM
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
/**
 * Class PutMoneyInPopup
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class PutMoneyInPopup extends Block
{
    public function waitForBtnCancel()
    {
        $btnCancel = $this->_rootElement->find('.cancel');
        if (!$btnCancel->isVisible()) {
            $this->waitForElementVisible('.cancel');
        }
    }
    public function getBtnCancel()
    {
        return $this->_rootElement->find('.cancel');
    }
    public function getTitleForm() {
        return $this->_rootElement->find('span[data-bind="i18n:adjustmentTitle()"]');
    }
    public function getDoneButton()
    {
        return $this->_rootElement->find('.button.btn-done');
    }
    public function getFormDescription()
    {
        return $this->_rootElement->find('span[data-bind="i18n:adjustmentNotice()"]');
    }
    public function getAmountInput()
    {
        return $this->_rootElement->find('input');
    }
    public function getErrorMessage()
    {
        return $this->_rootElement->find('span[data-bind="text: valueErrorMessage"]');
    }
    public function getReasonInput()
    {
        return $this->_rootElement->find('textarea');
    }
    public function getStaffName()
    {
        return $this->_rootElement->find('span[data-bind="text:staffName"]');
    }
}