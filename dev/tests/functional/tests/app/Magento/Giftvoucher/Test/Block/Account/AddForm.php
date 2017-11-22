<?php

namespace Magento\Giftvoucher\Test\Block\Account;

use Magento\Mtf\Block\Form;

class AddForm extends Form
{
    /**
     * 'Submit' form button
     * 
     * @var string
     */
    protected $submit = "button[type='submit']";
    
    /**
     * Add Gift Code to customer list
     * 
     * @param string $giftcode
     */
    public function addGiftcode($giftcode)
    {
        // Fill the form
        $fields = ['giftvouchercode' => $giftcode];
        $fields = $this->dataMapping($fields);
        $this->_fill($fields);
        // Click submit button
        $this->_rootElement->find($this->submit)->click();
    }
    
    public function waitPageInit()
    {
        $this->waitForElementVisible($this->submit);
    }
}
