<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/5/2018
 * Time: 9:33 AM
 */

namespace Magento\Webpos\Test\Block\OnHoldOrder;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class OnHoldOrderOrderList
 * @package Magento\Webpos\Test\Block\OnHoldOrder
 */
class OnHoldOrderOrderList extends Block
{

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getSearchOrderInput()
    {
        return $this->_rootElement->find('#search-header-order-hold');
    }

    /**
     * @param $string
     */
    public function search($string)
    {
        $this->_rootElement->find('#search-header-order-hold')->setValue($string);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getFirstOrder()
    {
        return $this->_rootElement->find('.list-orders .order-item');
    }

    /**
     * Waiting loader not visible
     */
    public function waitLoader()
    {
        $this->waitForElementNotVisible('.wrap-item-order .indicator');
    }

    public function getIconSearch()
    {
        return $this->_rootElement->find('.form-group .icon-iconPOS-search');
    }

    public function getIdFirstOrder()
    {
        return $this->_rootElement->find('div > div > ul > li.order-item > div > div.id-order > span.id')->getText();
    }
}