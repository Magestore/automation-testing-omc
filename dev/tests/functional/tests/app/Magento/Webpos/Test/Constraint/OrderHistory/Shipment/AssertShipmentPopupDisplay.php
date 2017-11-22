<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 05/10/2017
 * Time: 14:22
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShipmentPopupDisplay extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $products)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getShipmentPopupContainer()->isVisible(),
			'Ship popup is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getShipCancelButton()->isVisible(),
			'Ship Popup - Cancel button is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getShipSummitButton()->isVisible(),
			'Ship Popup - Submit Shipment button is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getShipCommentBox()->isVisible(),
			'Ship Popup - Comment textbox is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getShipSendEmailCheckbox()->isVisible(),
			'Ship Popup - Send Email Checkbox is not displayed'
		);

		foreach ($products as $product) {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getOrdersHistory()->getShipItemRow($product['name'])->isVisible(),
				'Ship Popup - Product '.$product['name'].' row is not displayed'
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$product['qty'],
				(int) $webposIndex->getOrdersHistory()->getShipItemQty($product['name']),
				"Ship Popup - Product ".$product['name']."'s qty is wrong"
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$product['qty'],
				(int) $webposIndex->getOrdersHistory()->getShipItemQtyInputBox($product['name'])->getValue(),
				"Ship Popup - Product ".$product['name']."'s ship qty is wrong"
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
		return "Order History - Shipment - Popup Display: Pass";
	}
}