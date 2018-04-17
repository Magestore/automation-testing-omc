<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 04/10/2017
 * Time: 16:06
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class Notification
 * @package Magento\WebposCheckGUICustomerPriceCP54EntityTest\Test\Block
 */
class Notification extends Block
{
	public function getNotificationBell()
	{
		return $this->_rootElement->find('.notification-bell');
	}

	public function getFirstNotification()
	{
		return $this->_rootElement->find('#webpos-notification > div.notification-info > div.notify-body > ul > li:nth-child(1)');
	}

	public function getFirstNotificationText()
	{
		return $this->getFirstNotification()->find('label[data-bind="text: label"]')->getText();
	}

	public function getCountNotification()
    {
        return $this->_rootElement->find('.notification-bell__mentions');
    }

    public function getClearAll()
    {
        return $this->_rootElement->find('//div[2]/div[1]/label[2]', Locator::SELECTOR_XPATH);
    }
}