<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 3:40 PM
 */

namespace Magento\Storepickup\Test\Block;

use Magento\Mtf\Block\Block;

/**
 * Class StorepickupPageTitle
 * @package Magento\Storepickup\Test\Block
 */
class StorepickupPageTitle extends Block
{
    /**
     * @return mixed
     */
    public function getStorepickupTitle()
    {
        return $this->_rootElement->getText();
    }
}