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

    public function getTakeMoneyOutButton()
    {
        return $this->_rootElement->find('[data-bind="click: takeMoneyOut"]');
    }

    public function getSetClosingBalanceButton()
    {
        return $this->_rootElement->find('[data-bind="click: setClosingBalance"]');
    }

}