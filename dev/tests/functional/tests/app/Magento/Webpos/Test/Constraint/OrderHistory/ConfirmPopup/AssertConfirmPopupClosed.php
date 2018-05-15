<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/01/2018
 * Time: 10:42
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\ConfirmPopup;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertConfirmPopupClosed
 * @package Magento\Webpos\Test\Constraint\SectionOrderHistory\ConfirmPopup
 */
class AssertConfirmPopupClosed extends AbstractConstraint
{
	/**
	 * @param WebposIndex $webposIndex
	 */
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirmation Popup is not closed'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Confirm Popup is closed";
	}
}