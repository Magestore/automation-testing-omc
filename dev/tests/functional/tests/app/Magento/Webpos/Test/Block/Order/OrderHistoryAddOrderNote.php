<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:31
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class OrderHistoryAddOrderNote
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryAddOrderNote extends Block
{
    public function openRefundPopup()
    {
        $this->_rootElement->find('.//a[text()="Refund"]', Locator::SELECTOR_XPATH)->click();
    }

    /**
     *
     */
    public function openShipmentPopup()
    {
        $this->_rootElement->find('.//a[text()="Ship"]', Locator::SELECTOR_XPATH)->click();
    }

    public function getSendMailButton()
    {
        return $this->_rootElement->find('a[data-bind^="text: $t(\'Send Email\')"]');
    }

    public function getShipButton()
    {
        return $this->_rootElement->find('a[data-bind^="text: $t(\'Ship\')"]');
    }

    public function getCancelButton()
    {
        return $this->_rootElement->find('a[data-bind^="text: $t(\'Cancel\')"]');
    }

    public function getAddCommentButton()
    {
        return $this->_rootElement->find('a[data-bind^="text: $t(\'Add Comment\')"]');
    }

    public function getReOrderButton()
    {
        return $this->_rootElement->find('a[data-bind^="text: $t(\'Re-order\')"]');
    }

    public function getRefundButton()
    {
        return $this->_rootElement->find('a[data-bind^="text: $t(\'Refund\')"]');
    }
}