<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 11:03
 */

namespace Magento\Webpos\Test\Block\Setting\Account;

use Magento\Mtf\Block\Block;
/**
 * Class StaffSettingFormMainAccount
 * @package Magento\Webpos\Test\Block\Setting
 */
class StaffSettingFormMainAccount extends Block
{
    public function getDisplayName()
    {
        return $this->_rootElement->find('#name');
    }
    public function getCurrentPassword()
    {
        return $this->_rootElement->find('#current-password');
    }
    public function getPassword()
    {
        return $this->_rootElement->find('#password');
    }
    public function getPasswordConfirmation()
    {
        return $this->_rootElement->find('#password-confirmation');
    }

    /**
     * Begin Get error messages
     */
    public function getDisplayNameErrorMessage()
    {
        return $this->_rootElement->find('#name-error');
    }
    public function getCurrentPasswordErrorMessage()
    {
        return $this->_rootElement->find('#current-password-error');
    }
    public function getNewPasswordErrorMessage()
    {
        return $this->_rootElement->find('#password-error');
    }
    public function getPasswordConfirmErrorMessage()
    {
        return $this->_rootElement->find('#password-confirmation-error');
    }
}