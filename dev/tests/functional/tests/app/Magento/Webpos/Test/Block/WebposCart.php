<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/11/2017
 * Time: 09:32
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
/**
 * Class WebposCart
 * @package Magento\Webpos\Test\Block
 */
class WebposCart extends Block
{
    public function getIconChangeCustomer()
    {
        return $this->_rootElement->find('.icon-iconPOS-change-customer');
    }

}