<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 14:13
 */

namespace Magento\FulfilSuccess\Test\Block\Adminhtml\Dashboard;

use Magento\Mtf\Block\Block;
/**
 * Class ContainerCarrier
 * @package Magento\FulfilSuccess\Test\Block\Adminhtml\Dashboard
 */
class ContainerCarrier extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getFirstHighChartsTitle()
    {
        return $this->_rootElement->find('.highcharts-title tspan:nth-child(1)');
    }
    public function getSecondHighChartsTitle()
    {
        return $this->_rootElement->find('.highcharts-title tspan:nth-child(2)');
    }
    public function getThirdHighChartsTitle()
    {
        return $this->_rootElement->find('.highcharts-title tspan:nth-child(3)');
    }
    public function getHighChartsButton()
    {
        return $this->_rootElement->find('.highcharts-button');
    }
}