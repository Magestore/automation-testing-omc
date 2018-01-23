<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:32
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
/**
 * Class OrderHistoryShipment
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryShipment extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getSubmitButton()
    {
        return $this->_rootElement->find('#shipment-popup-form > div.modal-body > div.actions > button.btn-cl-cfg-active');
    }
}