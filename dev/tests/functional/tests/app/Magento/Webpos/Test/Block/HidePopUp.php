<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/11/2017
 * Time: 13:17
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
/**
 * Class HidePopUp
 * @package Magento\Webpos\Test\Block
 */
class HidePopUp extends Block
{
    public function getHideElement()
    {
        return $this->_rootElement->find('.hide-popup');
    }
}