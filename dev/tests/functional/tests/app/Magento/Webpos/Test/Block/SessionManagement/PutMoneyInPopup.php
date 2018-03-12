<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/9/2018
 * Time: 8:48 AM
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;

class PutMoneyInPopup extends Block
{
    public function getDoneButton()
    {
        return $this->_rootElement->find('.button.btn-done');
    }

    public function getAmountInput()
    {
        return $this->_rootElement->find('input');
    }

    public function getReasonInput()
    {
        return $this->_rootElement->find('textarea');
    }
}