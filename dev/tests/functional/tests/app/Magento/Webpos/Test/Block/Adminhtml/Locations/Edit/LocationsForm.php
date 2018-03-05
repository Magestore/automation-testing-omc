<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 09:20:18
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-07 09:20:33
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Locations\Edit;

use Magento\Mtf\Block\Form;

class LocationsForm extends Form
{
    public function getField($id)
    {
        $id = '#'.$id;
        return $this->_rootElement->find($id);
    }
}
