<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/5/2018
 * Time: 1:42 PM
 */

namespace Magento\Webpos\Test\Block\OnHoldOrder;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;


/**
 * Class OnHoldOrderOrderViewFooter
 * @package Magento\Webpos\Test\Block\OnHoldOrder
 */
class OnHoldOrderOrderViewFooter extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getDeleteButton()
    {
        return $this->_rootElement->find('button.print');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCheckOutButton()
    {
        return $this->_rootElement->find('button.invoice');
    }

    /**
     * @param $label
     * @return array|string
     */
    public function getRowValue($label)
    {
        return $this->_rootElement->find('//*[@id="on_hold_orders_container"]/div/div[2]/footer/div[1]/table/tbody/tr/td[text()="'.$label.'"]/../td[2]', Locator::SELECTOR_XPATH)->getText();
    }
}