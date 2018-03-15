<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/7/2018
 * Time: 2:54 PM
 */
namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class SessionCloseShift
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class OpenSessionPopup extends Block
{
    /**
     * @param $name
     */
    public function setCoinBillValue($name)
    {
        $coin = $this->_rootElement->find('.cash-counting-value', Locator::SELECTOR_CSS, 'select');
        $coin->setValue($name);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function  getCoinBillValue(){
        return $this->_rootElement->find('.cash-counting-value');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function  getNumberOfCoinsBills(){
        return $this->_rootElement->find('.cash-counting-qty.a-center');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getOpenSessionButton()
    {
        $this->waitForElementNotVisible('[data-bind="visible:loading"]');
        sleep(1);
        return $this->_rootElement->find('button[type="submit"]');
    }

    public function getCancelButton()
    {
        return $this->_rootElement->find('.cancel');
    }

    public function setQtyCoinBill($number)
    {
        $coin = $this->_rootElement->find('.cash-counting-qty', Locator::SELECTOR_CSS, 'input');
        $coin->setValue($number);
    }

    public function getIconDeleteFirst()
    {
        return $this->_rootElement->find('.icon-iconPOS-delete');
    }

    public function setQtyCoinBillNumber($number, $vt)
    {
        $coin = $this->_rootElement->find('//input[@data-bind="value:cashQty"]', Locator::SELECTOR_CSS);
        $coin->setValue($number);
    }

    public function setCoinBillValueName($name, $vt)
    {
        $coin = $this->_rootElement->find('//select[@class="cash-counting-value"]', Locator::SELECTOR_CSS);
        $coin->setValue($name);
    }

    public function getIconAddNew()
    {
        return $this->_rootElement->find('.icon-iconPOS-add');
    }
}