<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 15:58
 */

namespace Magento\InventorySuccess\Test\TestCase\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\TranferToExternalStockHistory;
use Magento\Mtf\TestCase\Injectable;

class InventoryTranferToExternalHistoryAddNewTranferFromTest extends Injectable
{
	/**
	 * @var TranferToExternalStockHistory
	 */
	protected $tranferToExternalStockHistory;

	public function __inject(
		TranferToExternalStockHistory $tranferToExternalStockHistory
	)
	{
		$this->tranferToExternalStockHistory = $tranferToExternalStockHistory;
	}

	public function test()
	{
		$this->tranferToExternalStockHistory->open();
		$this->tranferToExternalStockHistory->getPageActionsBlock()->addNewTranfer();
	}
}