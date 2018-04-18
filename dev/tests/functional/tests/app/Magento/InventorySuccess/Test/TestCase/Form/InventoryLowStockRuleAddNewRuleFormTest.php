<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 14:56
 */

namespace Magento\InventorySuccess\Test\TestCase\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\LowStockRuleIndex;
use Magento\Mtf\TestCase\Injectable;

class InventoryLowStockRuleAddNewRuleFormTest extends Injectable
{
	/**
	 * @var LowStockRuleIndex
	 */
	protected $lowStockRuleIndex;

	public function __inject(
		LowStockRuleIndex $lowStockRuleIndex
	)
	{
		$this->lowStockRuleIndex = $lowStockRuleIndex;
	}

	public function test($pageTitle)
	{
		$this->lowStockRuleIndex->open();
		$this->lowStockRuleIndex->getPageActionsBlock()->addNew();
	}
}