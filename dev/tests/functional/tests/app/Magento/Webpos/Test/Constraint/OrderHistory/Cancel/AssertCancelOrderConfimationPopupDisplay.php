<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/10/2017
 * Time: 16:13
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Cancel;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCancelOrderConfimationPopupDisplay extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirmation Popup is not displayed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			"Are you sure you want to cancel this order?",
			$webposIndex->getModal()->getPopupMessage(),
			'Popup Message is wrong'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getCloseButton()->isVisible(),
			'Confirm popup - Close is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getCancelButton()->isVisible(),
			'Confirm popup - Cancel is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getOkButton()->isVisible(),
			'Confirm popup - OK is not displayed'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Cancel Order - Confirmation Popup Display: Pass";
	}
}