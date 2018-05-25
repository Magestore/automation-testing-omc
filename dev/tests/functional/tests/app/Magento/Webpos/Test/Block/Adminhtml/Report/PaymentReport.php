<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 8:44 AM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Report;

use Magento\Mtf\Block\Block;
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
}