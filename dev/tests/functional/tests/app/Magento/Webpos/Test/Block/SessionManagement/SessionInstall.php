<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 08/12/2017
 * Time: 17:27
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
/**
 * Class SessionInstall
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class SessionInstall extends Block
{
    public function getPercent()
    {
        return $this->_rootElement->find('.label-percent.first-rates-label-percent');
    }
}