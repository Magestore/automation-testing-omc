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
 * Class SessionRegisterShift
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class SessionRegisterShift extends Block
{
    public function getClosingBalanceButton()
    {
        return $this->_rootElement->find('//button[.//span[text()="Set Closing Balance"]]', locator::SELECTOR_XPATH);
    }

    public function getEndSessionButton()
    {
        return $this->_rootElement->find('.btn-close-shift');
    }

    public function getAddTransactionValue()
    {
        return $this->_rootElement->find('//div[@class="transactions-info"]//tbody[1]/tr[2]/td[2]/span', locator::SELECTOR_XPATH)->getText();
    }

    public function getSubtractTransactionValue()
    {
        return $this->_rootElement->find('//div[@class="transactions-info"]//tbody[1]/tr[3]/td[2]/span', locator::SELECTOR_XPATH)->getText();
    }

    public function waitLoader()
    {
        return $this->waitForElementVisible('#shift_container');
    }
}