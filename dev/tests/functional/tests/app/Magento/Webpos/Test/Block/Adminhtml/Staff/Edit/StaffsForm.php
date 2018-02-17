<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 14:35:45
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-07 14:41:26
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Staff\Edit;

use Magento\Mtf\Block\Form;

class StaffsForm extends Form
{
    public function getMessageRequired($id)
    {
        return $this->_rootElement->find('#'.$id)->getText();
    }
    public function isMessageRequiredDisplay($id)
    {
        return $this->_rootElement->find('#'.$id);
    }
}
