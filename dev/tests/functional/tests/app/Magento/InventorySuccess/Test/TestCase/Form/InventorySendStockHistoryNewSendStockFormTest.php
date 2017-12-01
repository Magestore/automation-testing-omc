<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 15:26
 */

namespace Magento\InventorySuccess\Test\TestCase\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\SendStockHistory;
use Magento\Mtf\TestCase\Injectable;

class InventorySendStockHistoryNewSendStockFormTest extends Injectable
{
	/**
	 * @var SendStockHistory
	 */
	protected $sendStockHistory;

	public function __inject(
		SendStockHistory $sendStockHistory
	)
	{
		$this->sendStockHistory = $sendStockHistory;
	}

	public function test()
	{
		$this->sendStockHistory->open();
		$this->sendStockHistory->getPageActionsBlock()->addNewSendStock();
	}
}