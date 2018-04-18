<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 08/12/2017
 * Time: 17:31
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
/**
 * Class SessionCloseShift
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class SessionCloseShift extends Block
{
    public function getConfirmSession()
    {
        return $this->_rootElement->find('button.btn-done');
    }
}