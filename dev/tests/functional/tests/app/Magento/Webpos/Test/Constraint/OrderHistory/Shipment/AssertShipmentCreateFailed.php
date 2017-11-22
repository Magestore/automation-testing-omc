<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/10/2017
 * Time: 14:35
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShipmentCreateFailed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertEquals(
			'Please choose an item to ship',
			$webposIndex->getModal()->getPopupMessage(),
			'Error Popup message is not showed'
		);

		$webposIndex->getModal()->getOkButton()->click();
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Shipment - Ship Qty = 0 : Pass";
	}
}