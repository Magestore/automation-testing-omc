<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-15 14:29:21
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-15 14:34:27
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;

class OrderList extends Block
{

    // Show all these pending status orders
    public function showPendingOrder()
    {
        $this->_rootElement->find('.wrap-status-orders .pending')->click();
    }

    // Show all these processing status orders
    public function showProcessingOrder()
    {
        $this->_rootElement->find('.wrap-status-orders .processing')->click();
    }

    // Show all these complete status orders
    public function showCompleteOrder()
    {
        $this->_rootElement->find('.wrap-status-orders .complete')->click();
    }
}
