<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Block\Giftcode;

/**
 * Class FormPageActions
 */
class FormPageActions extends \Magento\Backend\Test\Block\FormPageActions
{
    /**
     * "Save" button.
     *
     * @var string
     */
    protected $saveButton = '#save-button';
    
    /**
     * "Save and Send Email" button.
     * 
     * @var string
     */
    protected $saveAndSendEmailButton = '#save_and_send_email';
    
    /**
     * "Print" button
     * 
     * @var string
     */
    protected $printButton = '#print';
    
    /**
     * Dropdown Button
     * 
     * @var string
     */
    protected $dropdownButton = '[data-ui-id="save-button-dropdown"]';
    
    /**
     * Click "Save and Continue Edit" button.
     */
    public function saveAndContinue()
    {
        $this->waitForElementVisible($this->dropdownButton);
        $this->_rootElement->find($this->dropdownButton)->click();
        $this->_rootElement->find($this->saveAndContinueButton)->click();
        $this->waitForElementNotVisible('.popup popup-loading');
        $this->waitForElementNotVisible('.loader');
    }
    
    /**
     * Click "Save and Send Email" button.
     */
    public function saveAndSendEmail()
    {
        $this->waitForElementVisible($this->dropdownButton);
        $this->_rootElement->find($this->dropdownButton)->click();
        $this->_rootElement->find($this->saveAndSendEmailButton)->click();
        $this->waitForElementNotVisible('.popup popup-loading');
        $this->waitForElementNotVisible('.loader');
    }
    
    /**
     * Click "Print" button
     */
    public function clickPrint()
    {
        $this->_rootElement->find($this->printButton)->click();
    }
}
