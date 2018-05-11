<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/02/2018
 * Time: 20:34
 */
namespace Magento\Webpos\Test\Block\Adminhtml;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Block\Block;

/**
 * Class ModalsWrapper
 * @package Magento\Webpos\Test\Block\Adminhtml
 */
class ModalsWrapper extends Block
{
    public function getCancelButton()
    {
        return $this->_rootElement->find('//aside/div/footer/button[*[text()[normalize-space()="Cancel"]]]', Locator::SELECTOR_XPATH);
    }
    public function getOkButton()
    {
        return $this->_rootElement->find('//aside/div/footer/button[*[text()[normalize-space()="OK"]]]', Locator::SELECTOR_XPATH);
    }
    public function getXButton()
    {
        return $this->_rootElement->find('//aside/div/header/button[*[text()[normalize-space()="Close"]]]', Locator::SELECTOR_XPATH);
    }
    public function getMessageDelete()
    {
        return $this->_rootElement->find('.modal-content > div');
    }
    public function getAsidePopup()
    {
        return $this->_rootElement->find('//aside', Locator::SELECTOR_XPATH);
    }

    public function waitForLoader() {
        $this->waitForElementVisible('.modal-popup');
    }

    public function waitForHidden(){
        $this->waitForElementNotVisible('.modal-popup');
    }
    public function getModalPopup()
    {
        return $this->_rootElement->find('.modal-popup');
    }
}