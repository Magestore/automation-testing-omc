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
 * Class LocationReport
 * @package Magento\Webpos\Test\Block\Adminhtml\Report
 */
class LocationReport extends Block
{
    public function getPanelHeading() {
        return $this->_rootElement->find('.panel-heading');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getPOSSalesByLocationIcon() {
        return $this->_rootElement->find('.item-staff .icon-icon-Back-end-pos-salelocation');
    }
    public function getPOSSalesByLocationDailyIcon() {
        return $this->_rootElement->find('.item-staff .icon-icon-Back-end-pos-salelocationdaily');
    }
    public function getPOSOrderListLocationIcon() {
        return $this->_rootElement->find('.item-staff .icon-icon-Back-end-pos-orderlistlocation');
    }
}