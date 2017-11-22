<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Pattern;

/**
 * Class FormPageActions
 */
class FormPageActions extends \Magento\Backend\Test\Block\FormPageActions
{
    /**
     * "Save and Generate" Button
     * 
     * @var string
     */
    protected $saveAndGenerateButton = '#save_and_generate';
    
    /**
     * Click "Save and Generate" button.
     */
    public function saveAndGenerate()
    {
        $this->waitForElementVisible($this->saveAndGenerateButton);
        $this->_rootElement->find($this->saveAndGenerateButton)->click();
        $this->waitForElementNotVisible('.popup popup-loading');
        $this->waitForElementNotVisible('.loader');
    }
}
