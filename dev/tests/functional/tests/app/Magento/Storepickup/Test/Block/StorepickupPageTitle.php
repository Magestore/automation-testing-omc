<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 3:40 PM
 */

namespace Magento\Storepickup\Test\Block;

use Magento\Mtf\Block\Block;

class StorepickupPageTitle extends Block
{
    public function getStorepickupTitle()
    {
        return $this->_rootElement->getText();
    }
}