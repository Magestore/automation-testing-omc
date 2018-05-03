<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/14/2018
 * Time: 8:47 AM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Pos\Edit;

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
}