<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 16:35
 */

namespace Magento\InventorySuccess\Test\TestCase\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\AdjustStockIndex;
use Magento\Mtf\TestCase\Injectable;

class InventoryAdjustStockAddStockAdjustmentFormTest extends Injectable
{
	/**
	 * @var AdjustStockIndex
	 */
	protected $adjustStockIndex;

	public function __inject(
		AdjustStockIndex $adjustStockIndex
	)
	{
		$this->adjustStockIndex = $adjustStockIndex;
	}

	public function test()
	{
		$this->adjustStockIndex->open();
		$this->adjustStockIndex->getPageActionsBlock()->addNew();
	}
}