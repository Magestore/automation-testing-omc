<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 10:54
 */

namespace Magento\InventorySuccess\Test\Constraint\Menu;


use Magento\Backend\Test\Page\Adminhtml\Dashboard;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGridPageActionButtonsIsVisible extends AbstractConstraint
{
	public function processAssert(Dashboard $dashboard, $buttons = '')
	{
		$buttonLabels = explode(', ', $buttons);

		$dashboard->getGridBlock()->waitPageToLoad();
		foreach ($buttonLabels as $label) {
			\PHPUnit_Framework_Assert::assertTrue(
				$dashboard->getPageActionsBlock()->buttonIsVisible($label),
				'Button "'.$label.'" is not shown'
			);
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Page Action Buttons is visible";
	}
}