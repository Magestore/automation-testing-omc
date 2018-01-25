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
		return $this->_rootElement->find('.list-orders .order-item');
	}

	public function waitLoader()
	{
		$this->waitForElementNotVisible('.wrap-item-order .indicator');
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
}