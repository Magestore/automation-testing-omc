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

    public function getOptionByTitle($title)
    {
        return $this->_rootElement->find('//select//option[text()="' . $title . '"]', locator::SELECTOR_XPATH);
    }

    public function getPosNameErrorLabel(){
        return $this->_rootElement->find('#page_pos_name-error');
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

    public function waitForCurrentSessionLoad()
    {
        $this->waitForElementVisible('#admin_webpos_session_detail');
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

    public function getClosedAtSessionFirstRowData()
    {
        return $this->_rootElement->find('//div[@id="sessions_grid"]//tbody//tr[1]/td[4]', locator::SELECTOR_XPATH);
    }

    public function getCurrentSessionTitle($ttitle)
    {
        return $this->_rootElement->find('//legend[@class="admin__legend legend"]//span[text()="' . $ttitle . '"]', locator::SELECTOR_XPATH);
    }

    public function getCurrentSessionLabelByTitle($title)
    {
        return $this->_rootElement->find('//div[@class="transactions-info"]//label[text()="' . $title . '"]', locator::SELECTOR_XPATH);
    }

    public function getCurrentSessionButtonByTitle($title)
    {
        $this->waitForElementVisible('//div[@class="transactions-info"]//button[./span[text()="' . $title . '"]]',locator::SELECTOR_XPATH);
        return $this->_rootElement->find('//div[@class="transactions-info"]//button[./span[text()="' . $title . '"]]', locator::SELECTOR_XPATH);
    }

    public function getModal()
    {
        return $this->_rootElement->find('ancestor::body//div[@class="modals-wrapper"]', locator::SELECTOR_XPATH);
    }

    public function waitForModalLoad()
    {
        $this->waitForElementVisible('.modal-popup');
    }

    public function getPushMoneyInAmountField()
    {
        return $this->getModal()->find('#webpos-cash-adjustment-input-amount', locator::SELECTOR_CSS);
    }

    public function saveCashAdjustment()
    {
        $this->getModal()->find('//footer[@class="modal-footer"]//button[./span[text()="Save"]]', locator::SELECTOR_XPATH)->click();
    }

    public function getAddTransactionAmount(){
        return $this->_rootElement->find('//div[@class="transactions-info"]//div[@class="block"][1]//tbody/tr[2]/td[2]/span',locator::SELECTOR_XPATH)->getText();
    }

    public function getSubtractTransactionAmount(){
        return $this->_rootElement->find('//div[@class="transactions-info"]//div[@class="block"][1]//tbody/tr[3]/td[2]/span',locator::SELECTOR_XPATH)->getText();
    }

    public function waitForLoaderHidden()
    {
        $this->waitForElementNotVisible('.loading-mask');
    }

    public function setCashCountingQuanty($qty){
        if($this->_rootElement->find('.counting-box .cash-counting-qty')->isVisible()){
            $this->_rootElement->find('.counting-box .cash-counting-qty')->setValue($qty);
        }
    }
    public function saveClosingBalance(){
        $this->getModal()->find('//footer[@class="modal-footer"]//button[./span[text()="Confirm"]]', locator::SELECTOR_XPATH)->click();
    }
    public function confirmReason(){
       return $this->getModal()->find('//div[@id="modal-content-17"]/parent::*//footer[@class="modal-footer"]//button[./span[text()="Confirm"]]', locator::SELECTOR_XPATH);
    }

    public function waitForConfirmModalVisible(){
        $this->waitForElementVisible('.reason-box');
    }

    public function waitForModalClose(){
        $this->waitForElementNotVisible('.modals-wrapper');
    }

    public function validateClosing($title){
        $this->_rootElement->find('//div[@class="webpos-session-info"]//button/span[text()="'.$title.'"]',locator::SELECTOR_XPATH)->click();
    }
}
