<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/7/18
 * Time: 2:56 PM
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class MainContent
 * @package Magento\Webpos\Test\Block
 */
class MainContent extends Block
{
    public function clickOutsidePopup()
    {
        $this->_rootElement->click();
    }

}