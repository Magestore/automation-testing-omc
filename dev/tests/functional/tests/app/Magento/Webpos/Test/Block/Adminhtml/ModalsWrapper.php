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
    public function getCancleButton()
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
}