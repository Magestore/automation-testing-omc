<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/01/2018
 * Time: 10:13
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Cancel;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCancelPopupDisplay extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrderHistoryAddCancelComment()->isVisible(),
			'Cancel Popup is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrderHistoryAddCancelComment()->getCancelButton()->isVisible(),
			'Cancel Popup - Cancel Button is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrderHistoryAddCancelComment()->getSaveButton()->isVisible(),
			'Cancel Popup - Save Button is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrderHistoryAddCancelComment()->getCommentInput()->isVisible(),
			'Cancel Popup - Comment Input textbox is not displayed'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Cancel Order - Popup Display: Pass";
	}
}