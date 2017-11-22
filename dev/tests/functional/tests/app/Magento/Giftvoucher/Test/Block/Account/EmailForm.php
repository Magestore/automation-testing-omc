<?php

namespace Magento\Giftvoucher\Test\Block\Account;

use Magento\Mtf\Block\Form;

class EmailForm extends Form
{
    /**
     * 'Submit' form button
     *
     * @var string
     */
    protected $submit = "button[type='submit']";

    public function waitPageInit()
    {
        $this->waitForElementVisible($this->submit);
    }
}
