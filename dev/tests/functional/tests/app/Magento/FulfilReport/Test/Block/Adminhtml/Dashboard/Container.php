<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 13:49
 */

namespace Magento\FulfilReport\Test\Block\Adminhtml\Dashboard;

use Magento\Mtf\Block\Block;
/**
 * Class Container
 * @package Magento\FulfilSuccess\Test\Block\Adminhtml\Dashboard
 */
class Container extends Block
{
    /**
     * Fulfill Success Dashboard
     */
    public function getTimeRangeButton()
    {
        return $this->_rootElement->find('#time-range');
    }
    public function getTimeRangePerDayButton()
    {
        return $this->_rootElement->find('#time-range-perday');
    }
    public function getTimeRangeCarrierButton()
    {
        return $this->_rootElement->find('#time-range-carrier');
    }
    public function getTimeRangeVerifyButton()
    {
        return $this->_rootElement->find('#time-range-verify');
    }
    public function getTimeRangePickButton()
    {
        return $this->_rootElement->find('#time-range-pick');
    }
    public function getTimeRangePackButton()
    {
        return $this->_rootElement->find('#time-range-pack');
    }
}