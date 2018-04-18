<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 15:33
 */

namespace Magento\InventorySuccess\Test\Block\Adminhtml\RequestStockHistory;

use Magento\Backend\Test\Block\GridPageActions as ParentGridPageActions;

class GridPageActions extends ParentGridPageActions
{
	protected $newRequestStockButton = "#request";

	public function addNewRequestStock()
	{
		$this->_rootElement->find($this->newRequestStockButton)->click();
	}
}