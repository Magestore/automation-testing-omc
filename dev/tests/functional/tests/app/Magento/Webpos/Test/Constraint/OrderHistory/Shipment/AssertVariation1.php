<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/10/2017
 * Time: 08:18
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertVariation1 extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getShipmentPopupContainer()->isVisible(),
			'Shipment Popup is not closed'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Shipment - Variation 1: Pass";
	}
}