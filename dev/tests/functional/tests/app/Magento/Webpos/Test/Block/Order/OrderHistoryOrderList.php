<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:29
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
/**
 * Class OrderHistoryOrderList
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryOrderList extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getSearchOrderInput()
    {
        return $this->_rootElement->find('#search-header-order');
    }
	public function search($string)
	{
		$this->_rootElement->find('#search-header-order')->setValue($string);
	}

	public function getFirstOrder()
	{
		return $this->_rootElement->find('.list-orders .order-item');
	}

	public function waitLoader()
	{
		$this->waitForElementNotVisible('.wrap-item-order .indicator');
	}
}