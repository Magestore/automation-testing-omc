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

    public function waitCloseSession()
    {
        $defaultCurrentSession = $this->getDefaultCurrentSession('There are 0 open session');
        if(!$defaultCurrentSession->isVisible())
        {
            $browser = $this->_rootElement;
            $browser->waitUntil(
                function () use ($defaultCurrentSession) {
                    return $defaultCurrentSession->isVisible() ? true : null;
                }
            );
        }
    }

    public function getOptionByTitle($title)
    {
        return $this->_rootElement->find('//select//option[text()="' . $title . '"]', locator::SELECTOR_XPATH);
    }

    public function searchDenominationByName($name)
    {
        $this->_rootElement->find('input[name="denomination_name"]')->setValue($name);
        $this->_rootElement->find('button[data-action="grid-filter-apply"]')->click();
    }

    public function searchAndSelectDenominationByName($name)
    {
        $this->searchDenominationByName($name);
        $this->waitForElementVisible('#denomination_grid_table tbody');
        $this->waitForElementNotVisible('.loading-mask');
        $this->_rootElement->find('#denomination_grid_table th .admin__control-checkbox', locator::SELECTOR_CSS, 'checkbox')->setValue(true);
    }

    public function getDenominationFirstData()
    {
        return $this->_rootElement->find('//tbody/tr[@class="even"][1]', locator::SELECTOR_XPATH);
    }

    public function waitForSessionGridLoad()
    {
        $this->waitForElementVisible('#sessions_grid');
    }

    public function searchClosedSessionValue($id, $value, $type = null)
    {
        $element = $this->_rootElement->find('#' . $id, locator::SELECTOR_CSS, $type);
        $element->setValue($value);
        $this->_rootElement->find('#sessions_grid button[data-action="grid-filter-apply"]')->click();
        $this->waitForElementNotVisible('.loading-mask');
    }

    public function getEmptyRowOfSessionGrid()
    {
        return $this->_rootElement->find('//div[@id="Closed_Sessions"]//td[@class="empty-text"]', locator::SELECTOR_XPATH);
    }

    public function waitForCurrentSessionVisible()
    {
        $this->waitForElementVisible('#webpos_tabs_webpos_current_session_detail_content');
    }

    public function getCurrentSession()
    {
        return $this->_rootElement->find('#admin_webpos_session_detail');
    }

    public function getSetClosingBalance()
    {
        return $this->_rootElement->find('button[data-bind="click: setClosingBalance"]');
    }

    public function getValidateClosing()
    {
        return $this->_rootElement->find('.webpos-session-info')->find('//span[text()="Validate Closing"]', Locator::SELECTOR_XPATH);
    }

    public function waitValidateClosingVisible()
    {
        $validateClosing = $this->getValidateClosing();
        if(!$validateClosing->isVisible())
        {
            $this->_rootElement->waitUntil(
                function () use ($validateClosing) {
                    return $validateClosing->isVisible() ? true : null;
                }
            );
        }
    }
}
