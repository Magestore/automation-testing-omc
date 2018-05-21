<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/10/2017
 * Time: 16:08
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertCreateInvoiceSuccess
 * @package Magento\Webpos\Test\Constraint\OrderHistory\Invoice
 */
class AssertCreateInvoiceSuccess extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $expectStatus
     */
	public function processAssert(WebposIndex $webposIndex, $expectStatus)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not closed'
		);
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrderHistoryInvoice()->isVisible(),
			'Invoice Pop is not closed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->getWarningMessage()->isVisible(),
			'Success Message is not displayed'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'The invoice has been created successfully.',
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			"Success message's Content is Wrong"
		);
        $webposIndex->getOrderHistoryOrderViewHeader()->waitForChangeStatus($expectStatus);
		\PHPUnit_Framework_Assert::assertEquals(
			$expectStatus,
			$webposIndex->getOrderHistoryOrderViewHeader()->getStatus(),
			'Order Status is wrong'
		);
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->isVisible(),
			'Invoice Button is not hiden'
		);
		$webposIndex->getNotification()->getNotificationBell()->click();
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getNotification()->getFirstNotification()->isVisible(),
			'Notification list is empty'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'The invoice has been created successfully.',
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
		return "Order History - Invoice - Submit Invoice: Success";
	}
}