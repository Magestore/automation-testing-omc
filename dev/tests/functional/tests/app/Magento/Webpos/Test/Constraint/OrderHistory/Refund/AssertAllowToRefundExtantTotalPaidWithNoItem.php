<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/10/2017
 * Time: 13:21
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertAllowToRefundExtantTotalPaidWithNoItem extends AbstractConstraint
{
	public function processAssert(
		WebposIndex $webposIndex,
		AssertRefundSuccess $assertRefundSuccess,
		$totalRefunded
	)
	{
		$total = $webposIndex->getOrdersHistory()->getTotalPaid();

		if (!$webposIndex->getOrdersHistory()->getActionsBox()->isVisible()) {
			$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		}
		sleep(1);
		$text = 'Refund';
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getAction($text)->isVisible(),
			'Refund Extant Total Paid - Refund Action is not shown'
		);

		$webposIndex->getOrdersHistory()->getAction($text)->click();
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getRefundPopup()->isVisible(),
			'Refund Extant Total Paid - Refund Popup is not shown'
		);

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getRefundFirstItemRow()->isVisible(),
			'Refund Extant Total Paid - Items are still shown on table'
		);


		$adjustRefund = (float) $total - (float) $totalRefunded;
		$webposIndex->getOrdersHistory()->getRefundAdjustRefundBox()->setValue($adjustRefund);

		$webposIndex->getOrdersHistory()->getRefundSubmitButton()->click();
		$webposIndex->getModal()->getOkButton()->click();

		$expextStatus = 'Closed';
		$hideAction = 'Ship,Refund,Cancel';
		$totalRefund = null;

		$assertRefundSuccess->processAssert($webposIndex, $expextStatus, $hideAction, $totalRefund);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Refund - (Total refund < Total Paid) Allow to refund extant total paid: Pass";
	}
}