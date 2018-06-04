<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:29
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

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
        sleep(2);
//        $this->waitForFirstOrderVisible();
		return $this->_rootElement->find('.list-orders .order-item');
	}

	public function getSecondOrder()
    {
        return $this->_rootElement->find('//ul[@class="list-orders"]/li[2]', Locator::SELECTOR_XPATH);
    }

	public function waitForFirstOrderVisible() {
        $orderItem = $this->_rootElement->find('.list-orders .order-item');
        if (!$orderItem->isVisible()) {
            $this->waitForElementVisible('.list-orders .order-item');
        }
    }

    public function getFirstOrderId()
    {
        return $this->_rootElement->find('.list-orders .order-item .id');
    }

    public function getSecondOrderId()
    {
        return $this->_rootElement->find('//ul[@class="list-orders"]/li[2]/div/div[@class="id-order"]/span[@class="id"]', Locator::SELECTOR_XPATH);
    }

	public function waitLoader()
	{
		$this->waitForElementNotVisible('.wrap-item-order .indicator');
	}

	public function waitListOrders()
    {
        $this->waitForElementVisible('.wrap-item-order ul.list-orders');
    }

	public function getOrdersTitle()
    {
        return $this->_rootElement->find('[class="title title-header-page"]');
    }

    public function searchOrderIsVisible()
    {
        return $this->_rootElement->find('.//input[@placeholder="Search by name, email or order ID"]', Locator::SELECTOR_XPATH)->isVisible();
    }

    public function getPendingStatus()
    {
        return $this->_rootElement->find('[class="pending"]');
    }

    public function getProcessingStatus()
    {
        return $this->_rootElement->find('[class="processing"]');
    }

    public function getCompleteStatus()
    {
        return $this->_rootElement->find('[class="complete"]');
    }

    public function getCancelledStatus()
    {
        return $this->_rootElement->find('[class="canceled"]');
    }

    public function getClosedStatus()
    {
        return $this->_rootElement->find('[class="closed"]');
    }

    public function getNotSyncStatus()
    {
        return $this->_rootElement->find('[class="notsync"]');
    }

    public function orderListIsVisible()
    {
        return $this->_rootElement->find('.list-orders')->isVisible();
    }

    public function waitOrderListIsVisible()
    {
        $orderList = $this->_rootElement->find('.list-orders');
        if (!$orderList->isVisible()) {
            $this->waitForElementVisible('.list-orders');
        }
    }

    public function getAllOrderItems()
    {
        return $this->_rootElement->getElements('.item');
    }

}