<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 08/12/2017
 * Time: 17:26
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class SessionShift
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class SessionShift extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getButtonEndSession()
    {
        return $this->_rootElement->find('.btn-close-shift');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getOpenShiftButton() {
        return $this->_rootElement->find('[data-bind="afterRender:afterRenderOpenButton"]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getSetClosingBalanceButton()
    {
        return $this->_rootElement->find('button[data-bind="click: setClosingBalance"]');
    }

    public function getAddSession()
    {
        return $this->_rootElement->find('.icon-iconPOS-add');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getPutMoneyInButton()
    {
        return $this->_rootElement->find('button[data-bind="click: putMoneyIn"]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getTakeMoneyOutButton()
    {
        return $this->_rootElement->find('button[data-bind="click: takeMoneyOut"]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getPrintButton()
    {
        return $this->_rootElement->find('.footer-shift .btn-print');
    }

    /**
     * @param $label
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getTransactionsInfo($label){
        return $this->_rootElement->find('//div[@class="transactions-info"]/div/table/tbody/tr/td[1]/label[text()="'.$label.'"]/../../td[2]/span',Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCloseTime(){
        return $this->_rootElement->find('//tr[@data-bind="visible:isClosed()"]/td[2]/span', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getHidePopup(){
        return $this->_rootElement->find('.shift-wrap-backover.wrap-backover.hide-popup');
    }

    public function getBtnOpen()
    {
        return $this->_rootElement->find('.btn-open-shift');
    }

    public function getAddTransition()
    {
        return $this->_rootElement->find('//div/div[2]/header/div[2]/div[3]/div[1]/table/tbody/tr[2]/td[1]/a', Locator::SELECTOR_XPATH);
    }
}