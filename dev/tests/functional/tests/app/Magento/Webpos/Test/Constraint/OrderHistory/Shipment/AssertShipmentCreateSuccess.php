<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/10/2017
 * Time: 09:12
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShipmentCreateSuccess extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $statusAfterShip, $shipPartial)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not closed'
		);

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getShipmentPopupContainer()->isVisible(),
			'Shipment Pop is not closed'
		);

		sleep(10);
		\PHPUnit_Framework_Assert::assertEquals(
			$statusAfterShip,
			$webposIndex->getOrdersHistory()->getStatus(),
			'Status after created ship is wrong'
		);
		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		if ($shipPartial) {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getOrdersHistory()->getAction('Ship')->isVisible(),
				'Ship Action is hided'
			);
		} else {
			\PHPUnit_Framework_Assert::assertFalse(
				$webposIndex->getOrdersHistory()->getAction('Ship')->isVisible(),
				'Ship Action is not hided'
			);
		}

		$webposIndex->getNotification()->getNotificationBell()->click();
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getNotification()->getFirstNotification()->isVisible(),
			'Notification list is empty'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'The shipment has been created successfully.',
			$webposIndex->getNotification()->getFirstNotificationText(),
			'Notification Content is wrong'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Shipment Popup - Submit Shipment: Pass";
	}
}