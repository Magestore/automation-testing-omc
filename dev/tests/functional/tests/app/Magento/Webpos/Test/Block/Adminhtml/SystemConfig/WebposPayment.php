<?php
/**
 * Created by: thomas
 * Date: 03/11/2017
 * Time: 16:55
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Adminhtml\SystemConfig;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class WebposPayment extends Block
{

    public function setValueWebposPayment($value)
    {
        $multiSelect = $this->_rootElement->find('#webpos_payment_specificpayment',
            Locator::SELECTOR_CSS,
            'multiSelect'
        );
        $multiSelect->setValue($value);
    }

    public function saveWebposConfiguration()
    {
        return $this->_rootElement->find('#save', Locator::SELECTOR_CSS);
    }
}