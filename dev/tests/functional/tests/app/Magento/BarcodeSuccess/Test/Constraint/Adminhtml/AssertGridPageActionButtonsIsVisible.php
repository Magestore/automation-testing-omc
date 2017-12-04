<?php

namespace Magento\BarcodeSuccess\Test\Constraint\Adminhtml;
use Magento\Backend\Test\Page\Adminhtml\Dashboard;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGridPageActionButtonsIsVisible extends AbstractConstraint
{
	public function processAssert(Dashboard $dashboard, $buttons = '')
	{
		$buttonId = explode(', ', $buttons);

		$dashboard->getGridBlock()->waitPageToLoad();
		foreach ($buttonId as $id) {
			\PHPUnit_Framework_Assert::assertTrue(
				$dashboard->getPageActionsBlock()->buttonIsVisible($id),
				'Button "'.$id.'" is not shown'
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