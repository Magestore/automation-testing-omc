<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-08 11:05:05
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-08 11:05:31
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Pos\Edit;

use Magento\Mtf\Block\Form;
use Magento\Mtf\Client\Locator;
use function MongoDB\BSON\toJSON;

class PosForm extends Form
{
    public function lockRegisterSectionIsVisible()
    {
        return $this->_rootElement->find('[id="page_pin_fieldset"]')->isVisible();
    }

    public function getIsAllowToLockField()
    {
        return $this->_rootElement->find('[name="is_allow_to_lock"]', Locator::SELECTOR_CSS, 'select');
    }

    public function getPinNote()
    {
        return $this->_rootElement->find('[id="pin-note"]');
    }

    public function getSecurityPinField()
    {
        return $this->_rootElement->find('[name="pin"][type="password"]');
    }

    public function getSecurityPinError()
    {
        return $this->_rootElement->find('[id="page_pin-error"]');
    }

    public function getStatusFieldData()
    {
        return $this->_rootElement->find('[name="status"]')->getText();
    }

    public function setLocation($nameLocation)
    {
        $this->_rootElement->find('#page_location_id', locator::SELECTOR_CSS, 'select')->setValue($nameLocation);
    }

    public function setPosName($posName){
        $this->_rootElement->find('#page_pos_name')->setValue($posName);
    }

    public function waitLoader(){
        $this->waitForElementVisible('#edit_form');
    }
}
