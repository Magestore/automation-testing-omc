<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/24/2018
 * Time: 3:51 PM
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class OrderHistorySendEmail
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistorySendEmail extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCancelButton()
    {
        return $this->_rootElement->find('#send-email-order > div > div > form > div > button.close');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getSendButton()
    {
        return $this->_rootElement->find('#send-email-order > div > div > form > div > button.btn-save.link-cl-cfg');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getInputSendEmail()
    {
        return $this->_rootElement->find('#input-send-email-order');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getRequiredEmail()
    {
        return $this->_rootElement->find('#send-email-order .required-email');
    }

}