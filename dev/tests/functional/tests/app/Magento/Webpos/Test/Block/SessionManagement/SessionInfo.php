<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/9/2018
 * Time: 8:38 AM
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;

class SessionInfo extends Block
{
    public function getPutMoneyInButton()
    {
        return $this->_rootElement->find('[data-bind="click: putMoneyIn"]');
    }

    public function waitForTakeMoneyOutButton()
    {
        $takePayment = $this->_rootElement->find('[data-bind="click: takeMoneyOut"]');
        if (!$takePayment->isVisible()) {
            $this->waitForElementVisible('[data-bind="click: takeMoneyOut"]');
        }
    }

    public function getTakeMoneyOutButton()
    {
        return $this->_rootElement->find('[data-bind="click: takeMoneyOut"]');
    }

    public function getSetClosingBalanceButton()
    {
        return $this->_rootElement->find('[data-bind="click: setClosingBalance"]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getOpeningBalance()
    {
        return $this->_rootElement->find('[data-bind="text: formatPrice(shiftData().float_amount)"]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getDifferenceAmount()
    {
        return $this->_rootElement->find('[data-bind="text: formatPrice(differenceAmount())"]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getTheoreticalClosingBalance()
    {
        return $this->_rootElement->find('[data-bind="text: formatPrice(differenceAmount())"]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getAddTransactionTotal()
    {
        return $this->_rootElement->find('[data-bind="text: formatPrice(getAddTransactionTotal())"]');
    }
    public function getAddTransactionButton()
    {
        return $this->_rootElement->find('[data-bind="click:showRemoveTransactionsDetail"]');
    }
    public function getAddTransactionAmount()
    {
        return $this->_rootElement->find('[data-bind="text: formatPrice(getRemoveTransactionTotal())"]');
    }
    public function getTheoretialClosingBalance()
    {
        return $this->_rootElement->find('[data-bind="text: formatPrice(theoretialClosingBalance())"]');
    }
    public function getDifferentValue()
    {
        return $this->_rootElement->find('[data-bind="text: formatPrice(differenceAmount())"]');
    }
}