<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-19 10:49:33
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-19 10:50:45
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Staff;

use Magento\Mtf\Block\Form;

class SettingForm extends Form
{
    public function clickSaveButton()
    {
        $this->_rootElement->find('button[type="button"]')->click();
        return $this;
    }
}
