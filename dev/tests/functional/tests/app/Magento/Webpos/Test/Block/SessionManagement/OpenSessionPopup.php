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
    public function getCoinBillValue(){
        return $this->_rootElement->find('.cash-counting-value');
    }

    /**getNumberOfCoinsBills
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function waitNumberOfCoinsBills(){
        $quantity = $this->_rootElement->find('.cash-counting-qty.a-center');
        if (!$quantity->isVisible()) {
            $this->waitForElementVisible('.cash-counting-qty.a-center');
        }
    }
    public function getNumberOfCoinsBills(){
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

    public function getOpenSessionButtonElement()
    {
        return $this->_rootElement->find('button[type="submit"]');
    }

    public function waitLoader()
    {
        $this->waitForElementNotVisible('#popup-open-shift > div > div.indicator');
    }

    public function waitUntilForOpenSessionButtonVisible()
    {
        $this->waitForElementNotVisible('[data-bind="visible:loading"]');
        if (!$this->getOpenSessionButtonElement()->isVisible()) {
            $this->_rootElement->waitUntil(
                function () {
                    return $this->getOpenSessionButton()->isVisible() ? true : null;
                }
            );
        }
    }

    public function getLoadingElement(){
        return $this->_rootElement->find('[data-bind="visible:loading"]');
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

    public function getIconDeletes()
    {
        return $this->_rootElement->getElements('.icon-iconPOS-delete');
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

    public function isOpenSessionDisplay()
    {
        return $this->_rootElement->find('.shift-wrap-backover')->isVisible();
    }

    public function getStaff()
    {
        return $this->_rootElement->find('span[data-bind="text:staffName"]');
    }

    public function getPOS()
    {
        return $this->_rootElement->find('span[data-bind="text: window.webposConfig.posName"]');
    }

    public function getCoinBillValueColumn()
    {
        return $this->_rootElement
            ->find(
                '//*[@id="popup-open-shift"]/div/div[3]/div[2]/div[3]/table[1]/thead/tr/th[text() = "Coin/Bill Value"]',
                Locator::SELECTOR_XPATH
            );
    }

    public function getSubtotalColumn()
    {
        return $this->_rootElement
            ->find(
                '//*[@id="popup-open-shift"]/div/div[3]/div[2]/div[3]/table[1]/thead/tr/th[text() = "Subtotal"]',
                Locator::SELECTOR_XPATH
            );
    }

    public function getNumberOfCoinBillValueColumn()
    {
        return $this->_rootElement
            ->find(
                '//*[@id="popup-open-shift"]/div/div[3]/div[2]/div[3]/table[1]/thead/tr/th[text() = "Number of Coins/Bills"]',
                Locator::SELECTOR_XPATH
            );
    }

    public function getOpeningBalance()
    {
        return $this->_rootElement->find('span.opening-balance', Locator::SELECTOR_CSS);
    }

}