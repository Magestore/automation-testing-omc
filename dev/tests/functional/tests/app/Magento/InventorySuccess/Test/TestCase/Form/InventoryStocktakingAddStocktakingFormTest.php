<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 16:46
 */

namespace Magento\InventorySuccess\Test\TestCase\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\StocktakingIndex;
use Magento\Mtf\TestCase\Injectable;

class InventoryStocktakingAddStocktakingFormTest extends Injectable
{

	/**
	 * @var StocktakingIndex
	 */
	protected $stocktakingIndex;

	public function __inject(
		StocktakingIndex $stocktakingIndex
	)
	{
		$this->stocktakingIndex = $stocktakingIndex;
	}

	public function test()
	{
		$this->stocktakingIndex->open();
		$this->stocktakingIndex->getPageActionsBlock()->addNew();
	}
}