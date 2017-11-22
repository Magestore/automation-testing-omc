<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Block\GiftTemplate;

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
    protected $saveButton = '#save';
    
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
        //$this->waitForElementVisible($this->dropdownButton);
        //$this->_rootElement->find($this->dropdownButton)->click();
        $this->_rootElement->find($this->saveAndContinueButton)->click();
        $this->waitForElementNotVisible('.popup popup-loading');
        $this->waitForElementNotVisible('.loader');
    }
}
