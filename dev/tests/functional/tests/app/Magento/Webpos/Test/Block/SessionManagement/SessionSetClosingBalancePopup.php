<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/8/2018
 * Time: 3:34 PM
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class SessionSetClosingBalancePopup
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class SessionSetClosingBalancePopup extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getTitleBox()
    {
        return $this->_rootElement->find('.title-box');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCancelButton()
    {
        return $this->_rootElement->find('.cancel');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getConfirmButton()
    {
        return $this->_rootElement->find('.modal-body .btn-done');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getNotice()
    {
        return $this->_rootElement->find('.cash-counting-notice');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getAddNewRowButton()
    {
        return $this->_rootElement->find('//div[@class="counting-box"]/table[3]/tfoot/tr/td[1]/div/span', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getColumnCoin()
    {
        return $this->_rootElement->find('//div[@class="counting-box"]/table[1]/thead/tr/th[1]', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getColumnNumberOfCoins()
    {
        return $this->_rootElement->find('//div[@class="counting-box"]/table[1]/thead/tr/th[2]', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getColumnSubtotal()
    {
        return $this->_rootElement->find('//div[@class="counting-box"]/table[1]/thead/tr/th[3]', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function  getNumberOfCoinsBills(){
        return $this->_rootElement->find('.cash-counting-qty.a-center');
    }
}