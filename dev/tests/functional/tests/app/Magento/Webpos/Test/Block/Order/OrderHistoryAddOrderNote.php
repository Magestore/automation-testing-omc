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
}