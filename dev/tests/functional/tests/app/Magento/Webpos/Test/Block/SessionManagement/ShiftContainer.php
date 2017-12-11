<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 08/12/2017
 * Time: 17:26
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
/**
 * Class ShiftContainer
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class ShiftContainer extends Block
{
    public function getButtonEndSession()
    {
        return $this->_rootElement->find('.btn-close-shift');
    }

}