<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/10/2017
 * Time: 14:58
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Cancel;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCreatedInvoiceCancelExtantItems extends AbstractConstraint
{
	public function processAssert(
		WebposIndex $webposIndex,
		AssertCancelOrderSuccess $assertCancelOrderSuccess,
		$orderId
	)
	{
		sleep(10);
		$status = $webposIndex->getOrdersHistory()->getStatus();
		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		$cancelText = 'Cancel';
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getAction($cancelText)->isVisible(),
			'Cancel Action is not displayed'
		);

		$webposIndex->getOrdersHistory()->getAction($cancelText)->click();
		sleep(1);
		$webposIndex->getOrdersHistory()->getCancelOrderSaveButton()->click();
		$webposIndex->getModal()->getOkButton()->click();
		$assertCancelOrderSuccess->processAssert($webposIndex, $status);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Cancel Order - Create Invoice Partial - Cancel Extant Items: Pass";
	}
}