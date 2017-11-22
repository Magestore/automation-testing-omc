<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 13/09/2017
 * Time: 15:15
 */

namespace Magento\Webpos\Test\Block\Login;

use Magento\Mtf\Block\Form;

class LoginForm extends Form
{
	public function getUsernameField()
	{
		return $this->_rootElement->find('#username');
	}
	public function getPasswordField()
	{
		return $this->_rootElement->find('#pwd');
	}


	public function clickLoginButton()
	{
		$this->_rootElement->find('button[type="submit"]')->click();
		return $this;
	}

	public function getLogo()
	{
		return $this->_rootElement->find('#webpos-login > h1 > img');
	}

	public function getUsernameErrorMessage()
	{
		return $this->_rootElement->find('#username-error');
	}

	public function getPasswordErrorMessage()
	{
		return $this->_rootElement->find('#pwd-error');
	}
}
