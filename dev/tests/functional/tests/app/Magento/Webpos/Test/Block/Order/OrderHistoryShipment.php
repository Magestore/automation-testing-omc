<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:32
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class OrderHistoryShipment
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryShipment extends Block
{
    protected $itemRowTemplate = './/tr[.//*[@class="product-name" and text()="%s"]]';

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getSubmitButton()
    {
        return $this->_rootElement->find('#shipment-popup-form > div.modal-body > div.actions > button.btn-cl-cfg-active');
    }
    public function getSubmitButtonNotWait()
    {
        return $this->_rootElement->find('#shipment-popup-form > div.modal-body > div.actions > button.btn-cl-cfg-active');
    }

    public function getCancelButton()
    {
        return $this->_rootElement->find('[class="close"]');
    }

    public function getRowItem($productName)
    {
        $itemRowTemplate = sprintf($this->itemRowTemplate, $productName);
        return $this->_rootElement->find($itemRowTemplate, Locator::SELECTOR_XPATH);
    }

    public function getOrderProductQty($productName)
    {
        $itemRow = $this->getRowItem($productName);
        return $itemRow->find('[data-bind="text: item.qty_ordered - item.qty_shipped - item.qty_refunded - item.qty_canceled"]')->getText();
    }

    public function getQtyToShipInput($productName)
    {
        $itemRow = $this->getRowItem($productName);
        return $itemRow->find('.//input', Locator::SELECTOR_XPATH);
    }

    public function getShipmentComment()
    {
        return $this->_rootElement->find('[name="comment_text"]');

    }

    public function getSendMailCheckbox()
    {
        return $this->_rootElement->find('[id="send_email_ship_popup"]');
    }

    public function getTrackNumber()
    {
        return $this->_rootElement->find('input[name="tracking[1][number]"]');
    }
}