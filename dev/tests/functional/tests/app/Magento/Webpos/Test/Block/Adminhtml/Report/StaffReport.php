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
 * Class StaffReport
 * @package Magento\Webpos\Test\Block\Adminhtml\Report
 */
class StaffReport extends Block
{
    public function getPanelHeading() {
        return $this->_rootElement->find('.panel-heading');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getPOSSalesByStaffIcon() {
        return $this->_rootElement->find('.item-staff .icon-icon-Back-end-pos-salestaff');
    }
    public function getPOSSalesByStaffDailyIcon() {
        return $this->_rootElement->find('.item-staff .icon-icon-Back-end-pos-salestaffdaily');
    }
    public function getPOSOrderListStaffIcon() {
        return $this->_rootElement->find('.item-staff .icon-icon-Back-end-pos-orderliststaff');
    }
}