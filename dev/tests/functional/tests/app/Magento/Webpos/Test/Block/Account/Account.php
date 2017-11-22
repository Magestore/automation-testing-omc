<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/09/2017
 * Time: 11:03
 */

namespace Magento\Webpos\Test\Block\Account;


use Magento\Mtf\Block\Block;

class Account extends Block
{
	public function getDisplayNameField()
	{
		return $this->_rootElement->find('#name');
	}

	public function getCurrentPasswordField()
	{
		return $this->_rootElement->find('#current-password');
	}

	public function getNewPasswordField()
	{
		return $this->_rootElement->find('#password');
	}

	public function getConfirmationField()
	{
		return $this->_rootElement->find('#password-confirmation');
	}

	public function getSaveButton()
	{
		return $this->_rootElement->find('button[data-bind="i18n:\'Save\',click: saveStaffInformation"]');
	}

	public function getNameErrorMessage()
	{
		return $this->_rootElement->find('#name-error');
	}

	public function getCurrentPasswordErrorMessage()
	{
		return $this->_rootElement->find('#current-password-error');
	}

	public function getPasswordErrorMessage()
	{
		return $this->_rootElement->find('#password-error');
	}

	public function getConfirmPasswordErrorMessage()
	{
		return $this->_rootElement->find('#password-confirmation-error');
	}
}