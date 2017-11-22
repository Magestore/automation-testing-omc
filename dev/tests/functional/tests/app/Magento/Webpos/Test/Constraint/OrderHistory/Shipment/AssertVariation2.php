<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/10/2017
 * Time: 08:20
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertVariation2 extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not closed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getShipmentPopupContainer()->isVisible(),
			'Shipment Pop is not displayed'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Shipment Popup - Close Confirm Popup: Pass";
	}
}