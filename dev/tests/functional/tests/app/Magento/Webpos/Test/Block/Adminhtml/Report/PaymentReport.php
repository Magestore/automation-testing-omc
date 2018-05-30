<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 8:44 AM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Report;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class PaymentReport
 * @package Magento\Webpos\Test\Block\Adminhtml\Report
 */
class PaymentReport extends Block
{
    public function getPanelHeading() {
        return $this->_rootElement->find('.panel-heading');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getPOSSalesByPaymentIcon() {
        return $this->_rootElement->find('.item-staff .icon-icon-Back-end-pos-salepayment');
    }
    public function getPOSSalesByPaymentDailyIcon() {
        return $this->_rootElement->find('.item-staff .icon-icon-Back-end-pos-salepaymentdaily');
    }
    public function getPOSOrderListPaymentIcon() {
        return $this->_rootElement->find('.item-staff .icon-icon-Back-end-pos-orderlistpayment');
    }
    public function getPOSSalesByPaymentMethodLocationIcon() {
        return $this->_rootElement->find('.item-staff .icon-icon-Back-end-pos-salepaymentlocation');
    }

    protected function getTRPaymentMethodCashIn()
    {
        return $this->_rootElement->find('//td[contains(.,"Web POS - Cash In")]/..', Locator::SELECTOR_XPATH);
    }

    protected function getTRPaymentMethodCashOnDelivery()
    {
        return $this->_rootElement->find('//td[contains(.,"Web POS - Cash On Delivery")]/..', Locator::SELECTOR_XPATH);
    }

    protected function getTRPaymentMethodCustomPayment1()
    {
        return $this->_rootElement->find('//td[contains(.,"Web POS - Custom payment 1")]/..', Locator::SELECTOR_XPATH);
    }

    public function getCashInOrderCount()
    {
        return $this->getTRPaymentMethodCashIn()->find('.col-orders');
    }

    public function getCashInSalesTotal()
    {
        return $this->getTRPaymentMethodCashIn()->find('.col-sales-total');
    }

    public function getCashOnDeliveryOrderCount()
    {
        return $this->getTRPaymentMethodCashOnDelivery()->find('.col-orders');
    }

    public function getCashOnDeliverySalesTotal()
    {
        return $this->getTRPaymentMethodCashOnDelivery()->find('.col-sales-total');
    }

    public function getCustomPayment1OrderCount()
    {
        return $this->getTRPaymentMethodCustomPayment1()->find('.col-orders');
    }

    public function getCustomPayment1SalesTotal()
    {
        return $this->getTRPaymentMethodCustomPayment1()->find('.col-sales-total');
    }
}