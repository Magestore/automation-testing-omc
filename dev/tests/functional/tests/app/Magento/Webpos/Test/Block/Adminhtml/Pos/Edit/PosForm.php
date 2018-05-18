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
/**
 * Class PosForm
 * @package Magento\Webpos\Test\Block\Adminhtml\Pos\Edit
 */
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

    public function setPosName($posName)
    {
        $this->_rootElement->find('#page_pos_name')->setValue($posName);
    }

    public function setFieldByValue($id, $value, $type = null)
    {
        if ($type == 'select') {
            $this->_rootElement->find('#' . $id, locator::SELECTOR_CSS, $type)->setValue($value);
        } else {
            $this->_rootElement->find('#' . $id, locator::SELECTOR_CSS)->setValue($value);
        }
    }

    public function waitLoader()
    {
        $this->waitForElementVisible('#edit_form');
    }

    public function getTabByTitle($title)
    {
        return $this->_rootElement->find('//li[@role="tab"]/a/span[text()="' . $title . '"]', locator::SELECTOR_XPATH);
    }

    public function getGeneralFieldByTitle($title)
    {
        return $this->_rootElement->find('//fieldset//label/span[text()="' . $title . '"]', locator::SELECTOR_XPATH);
    }

    public function getGeneralFieldById($id, $type = null)
    {
        return $this->_rootElement->find('#' . $id, locator::SELECTOR_CSS, $type);
    }

    public function getDenominationFieldByTitle($title)
    {
        return $this->_rootElement->find('//table/thead//th/span[text()="' . $title . '"]', locator::SELECTOR_XPATH);
    }

    public function getSessionRowWithNoData()
    {
        return $this->_rootElement->find('#sessions_grid_table .empty-text');
    }

    public function getDefaultCurrentSession($title)
    {
        return $this->_rootElement->find('//legend[@class="admin__legend legend"]/span[text()="' . $title . '"]', locator::SELECTOR_XPATH);
    }

    public function getOptionByTitle($title)
    {
        return $this->_rootElement->find('//select//option[text()="' . $title . '"]', locator::SELECTOR_XPATH);
    }

    public function searchDenominatioByName($name)
    {
        $this->_rootElement->find('input[name="denomination_name"]')->setValue($name);
        $this->_rootElement->find('button[data-action="grid-filter-apply"]')->click();
    }

    public function getDenominationFirstData()
    {
        return $this->_rootElement->find('//tbody/tr[@class="even"][1]', locator::SELECTOR_XPATH);
    }
}
