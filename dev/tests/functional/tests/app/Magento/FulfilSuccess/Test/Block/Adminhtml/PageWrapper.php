<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 13:38
 */

namespace Magento\FulfilSuccess\Test\Block\Adminhtml;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Locator;
/**
 * Class PageWrapper
 * @package Magento\FulfilSuccess\Test\Block\Adminhtml
 */
class PageWrapper extends DataGrid
{
    /**
     * Order Fulfilment
     */
    public function getVerifyButton()
    {
        return $this->_rootElement->find('#verify_order');
    }
    public function getPrepareButton()
    {
        return $this->_rootElement->find('#prepare_ship');
    }
    public function getPickItemButton()
    {
        return $this->_rootElement->find('#pick_item');
    }
    public function getPackItemButton()
    {
        return $this->_rootElement->find('#pack_item');
    }
    public function getPackageButton()
    {
        return $this->_rootElement->find('#package');
    }
    public function getDeliveryPackageButton()
    {
        return $this->_rootElement->find('#package');
    }
    /**
     * Order Listing
     */
    public function getAllOrderButton()
    {
        return $this->_rootElement->find('#all_order');
    }
    public function getAwaitingPaymentButton()
    {
        return $this->_rootElement->find('#awaitingpayment_order');
    }
    public function getBackOrderButton()
    {
        return $this->_rootElement->find('#back_order');
    }
    public function getHoldOrderButton()
    {
        return $this->_rootElement->find('#hold_order');
    }
    public function getCompletedOrderButton()
    {
        return $this->_rootElement->find('#completed_order');
    }
    public function getCanceledOrderButton()
    {
        return $this->_rootElement->find('#canceled_order');
    }
    public function getColumnByName($columnLabel)
    {
        $this->waitLoader();
        $this->getTemplateBlock()->waitForElementNotVisible($this->loader);
        return $this->_rootElement->find(sprintf($this->columnHeader, $columnLabel), Locator::SELECTOR_XPATH);
    }
}