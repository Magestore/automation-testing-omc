<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/10/2017
 * Time: 08:05
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShipmentConfirmPopupDisplay extends AbstractConstraint
{

	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getCloseButton()->isVisible(),
			'Ship Confirm popup - Close is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getCancelButton()->isVisible(),
			'Ship Confirm popup - Cancel is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getOkButton()->isVisible(),
			'Ship Confirm popup - OK is not displayed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'Are you sure you want to ship this order?',
			$webposIndex->getModal()->getPopupMessage(),
			'Ship Confirm popup - Message content is wrong'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Shipment - Confirm Popup Display: Pass";
	}
}