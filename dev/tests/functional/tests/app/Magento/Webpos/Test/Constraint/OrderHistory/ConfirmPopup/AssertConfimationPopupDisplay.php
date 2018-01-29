<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/01/2018
 * Time: 10:06
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\ConfirmPopup;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertConfimationPopupDisplay extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $message)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirmation Popup is not displayed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$message,
			$webposIndex->getModal()->getPopupMessage(),
			'Confirm popup - Popup Message is wrong'
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
		return "Confirmation Popup Display: Pass";
	}
}