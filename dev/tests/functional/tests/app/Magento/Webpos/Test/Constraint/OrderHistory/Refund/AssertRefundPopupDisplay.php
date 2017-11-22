<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 20/10/2017
 * Time: 08:10
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundPopupDisplay extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $products)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getRefundPopup()->isVisible(),
			'Refund popup is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getRefundCancelButton()->isVisible(),
			'Refund Popup - Cancel Button is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getRefundRefundOfflineButton()->isVisible(),
			'Refund Popup - Refund Offline Button is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getRefundSubmitButton()->isVisible(),
			'Refund Popup - Submit Button is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getRefundSendEmailCheckbox()->isVisible(),
			'Refund Popup - Send Email Checkbox is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getRefundCommentBox()->isVisible(),
			'Refund Popup - Comment Textbox is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getRefundAdjustRefundBox()->isVisible(),
			'Refund Popup - Adjust Refund Textbox is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getRefundAdjustFee()->isVisible(),
			'Refund Popup - Adjust Fee Textbox is not displayed'
		);

		foreach ($products as $product) {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getOrdersHistory()->getRefundItemRow($product['name'])->isVisible(),
				'Refund Popup - Product '.$product['name'].' row is not displayed'
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$product['qty'],
				(int) $webposIndex->getOrdersHistory()->getRefundItemQty($product['name']),
				"Refund Popup - Product ".$product['name']."'s qty is wrong"
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$product['qty'],
				(int) $webposIndex->getOrdersHistory()->getRefundItemQtyToRefundInput($product['name'])->getValue(),
				"Refund Popup - Product ".$product['name']."'s qty to refund is wrong"
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
		return "Order History - Refund - Popup Display: Pass";
	}
}