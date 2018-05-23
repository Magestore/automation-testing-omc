<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/12/2017
 * Time: 08:41
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
/**
 * Class OWrapper
 * @package Magento\Webpos\Test\Block
 */
class OWrapper extends Block
{
    public function getCMenuButton()
    {
        return $this->_rootElement->find('#c-button--push-left');
    }
}