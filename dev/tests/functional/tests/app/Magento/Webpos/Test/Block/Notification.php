<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 04/10/2017
 * Time: 16:06
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;

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
}