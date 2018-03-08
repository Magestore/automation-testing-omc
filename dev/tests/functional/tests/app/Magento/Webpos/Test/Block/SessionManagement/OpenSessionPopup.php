<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/7/2018
 * Time: 2:54 PM
 */
namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
/**
 * Class SessionCloseShift
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class OpenSessionPopup extends Block
{
    public function getOpenSessionButton()
    {
        $this->waitForElementNotVisible('[data-bind="visible:loading"]');
        sleep(1);
        return $this->_rootElement->find('button[type="submit"]');
    }
}