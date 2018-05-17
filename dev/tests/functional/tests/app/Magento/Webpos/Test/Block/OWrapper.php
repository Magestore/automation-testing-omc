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

    public function clickOutSidePopup() {
        $this->_rootElement->find('//*[@id="o-wrapper"]/div/div/div[3]/div[10]')->rightClick();
    }
}