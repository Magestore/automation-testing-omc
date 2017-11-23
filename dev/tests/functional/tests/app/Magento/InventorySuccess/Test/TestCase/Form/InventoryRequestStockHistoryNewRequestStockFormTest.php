<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 15:47
 */

namespace Magento\InventorySuccess\Test\TestCase\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\RequestStockHistory;
use Magento\Mtf\TestCase\Injectable;

class InventoryRequestStockHistoryNewRequestStockFormTest extends Injectable
{
	/**
	 * @var RequestStockHistory
	 */
	protected $requestStockHistory;

	public function __inject(
		RequestStockHistory $requestStockHistory
	)
	{
		$this->requestStockHistory = $requestStockHistory;
	}

	public function test()
	{
		$this->requestStockHistory->open();
		$this->requestStockHistory->getPageActionsBlock()->addNewRequestStock();
	}
}