<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 14:14
 */

namespace Magento\FulfilReport\Test\Block\Adminhtml\Dashboard;

use Magento\Mtf\Block\Block;
/**
 * Class ContainerPick
 * @package Magento\FulfilSuccess\Test\Block\Adminhtml\Dashboard
 */
class ContainerPick extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getHighChartsTitle()
    {
        return $this->_rootElement->find('.highcharts-title tspan');
    }
    public function getHighChartsButton()
    {
        return $this->_rootElement->find('.highcharts-button');
    }
}