<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/12/2017
 * Time: 08:47
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
/**
 * Class OrderHistoryContainer
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryContainer extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getSearchOrderInput()
    {
        return $this->_rootElement->find('#search-header-order');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getOrderNote()
	{
		return $this->_rootElement->find('div.order-comment-list > table > tbody > tr > td:nth-child(2)');
	}

    /**
     * @return bool|null
     */
    public function waitOrderHistoryInvoiceIsVisible()
    {
        return $this->waitForElementVisible('#invoice-popup');
    }

	public function getActionsBox()
	{
		return $this->_rootElement->find('#form-add-note-order');
	}
}