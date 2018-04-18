<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 08/12/2017
 * Time: 17:38
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
/**
 * Class SessionSetClosingBalanceReason
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class SessionSetClosingBalanceReason extends Block
{
    public function getButtonBtnDone()
    {
        return $this->_rootElement->find('button.btn-done');
    }
}