<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 10:07
 */

namespace Magento\InventorySuccess\Test\Constraint\Menu;


use Magento\Backend\Test\Page\Adminhtml\Dashboard;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGridTableIsVisible extends AbstractConstraint
{
	public function processAssert(Dashboard $dashboard)
	{
		$dashboard->getGridBlock()->waitPageToLoad();
		\PHPUnit_Framework_Assert::assertTrue(
			$dashboard->getGridBlock()->TableIsVisible(),
			'Grid Table is not shown'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Grid Table is visible";
	}
}