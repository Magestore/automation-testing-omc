<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 15:33
 */

namespace Magento\InventorySuccess\Test\Block\Adminhtml\TranferToExternalStockHistory;

use Magento\Backend\Test\Block\GridPageActions as ParentGridPageActions;

class GridPageActions extends ParentGridPageActions
{
	protected $newTranferButton = '[title="New Transfer"]';

	public function addNewTranfer()
	{
		$this->_rootElement->find($this->newTranferButton)->click();
	}
}