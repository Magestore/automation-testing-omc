<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 13/09/2017
 * Time: 15:15
 */

namespace Magento\Webpos\Test\Block\Login;

use Magento\Mtf\Block\Form;
use Magento\Mtf\Client\Locator;

class LoginForm extends Form
{
    public function waitForLoginForm()
    {
        $this->waitForElementVisible('#webpos-login');
    }
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

	public function getLocationID()
    {
	    return $this->_rootElement->find('//*[@id="location"]', Locator::SELECTOR_XPATH);
    }

    public function selectLocation($name)
    {
        $this->getLocationID()->click();
        return $this->_rootElement->find('//*[@id="location"]/option[text()="'.$name.'"]', Locator::SELECTOR_XPATH);
    }
    public function setLocation($name)
    {
        $location = $this->_rootElement->find('#location', Locator::SELECTOR_CSS, 'select');
        $location->setValue($name);
    }

	public function getPosID()
    {
	    return $this->_rootElement->find('//*[@id="pos"]', Locator::SELECTOR_XPATH);
    }

    public function selectPos($name)
    {
        $this->getPosID()->click();
        return $this->_rootElement->find('//*[@id="pos"]/option[text()="'.$name.'"]', Locator::SELECTOR_XPATH);
    }

    public function setPos($name)
    {
        $location = $this->_rootElement->find('#pos', Locator::SELECTOR_CSS, 'select');
        $location->setValue($name);
    }

    public function getEnterToPos()
    {
        return $this->_rootElement->find('button.btn-default');
    }
}
