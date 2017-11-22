<?php

namespace Magento\Giftvoucher\Test\Block\Adminhtml\Block\GiftTemplate;

use Magento\Backend\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Client\Element\SimpleElement;

/**
 * Backend Form for Gift Card Template Entity
 */
class Form extends FormTabs
{
    /**
     * Magento form loader.
     *
     * @var string
     */
    protected $spinner = '[data-role="spinner"]';
    
    /**
     * Wait page to load.
     *
     * @return void
     */
    protected function waitPageToLoad()
    {
        $this->waitForElementNotVisible($this->spinner);
    }
    
    /**
     * (non-PHPdoc)
     * @see \Magento\Ui\Test\Block\Adminhtml\AbstractFormContainers::fill()
     */
    public function fill(FixtureInterface $fixture, SimpleElement $element = null)
    {
        $this->waitPageToLoad();
        parent::fill($fixture, $element);
    }
}
