<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 11/01/2018
 * Time: 15:34
 */
namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
/**
 * Class Body
 * @package Magento\Webpos\Test\Block
 */
class Body extends Block
{
    public function getPageStyleMinHeight()
    {
        $style = $this->_rootElement->find('[data-role="page"]')->getAttribute('style');
        $minHeight = str_replace('min-height: ', '', $style);
        $minHeight = (float)str_replace('px;', '', $minHeight);
        return $minHeight;
    }
}