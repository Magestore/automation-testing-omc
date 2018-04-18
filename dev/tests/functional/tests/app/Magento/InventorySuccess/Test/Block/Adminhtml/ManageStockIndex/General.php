<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 09:13
 */

namespace Magento\InventorySuccess\Test\Block\Adminhtml\ManageStockIndex;


use Magento\Mtf\Block\Block;

class General extends Block
{
	public function getSelectWarehouseOption()
	{
		return $this->_rootElement->find('#select_warehouse_option');
	}
}