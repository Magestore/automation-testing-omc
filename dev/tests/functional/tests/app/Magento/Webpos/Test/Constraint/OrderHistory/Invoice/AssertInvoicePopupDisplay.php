<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/10/2017
 * Time: 14:51
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertInvoicePopupDisplay extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $products)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getInvoicePopup()->isVisible(),
			'Invoice popup is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getInvoiceCancelButton()->isVisible(),
			'Invoice popup - Cancel button is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getInvoiceSubmitButton()->isVisible(),
			'Invoice popup - Submit button is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getInvoiceSendEmailCheckbox()->isVisible(),
			'Invoice Popup - Send email Checkbox is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getInvoiceCommentInput()->isVisible(),
			'Invoice Popup - Comment input box is not displayed'
		);

		foreach ($products as $product) {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getOrdersHistory()->getInvoiceItemRow($product['name'])->isVisible(),
				'Invoice Popup - Product '.$product['name'].' row is not displayed'
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$product['qty'],
				(int) $webposIndex->getOrdersHistory()->getInvoiceItemOrderedQty($product['name']),
				"Invoice Popup - Product ".$product['name']."'s ordered qty is wrong"
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$product['qty'],
				(int) $webposIndex->getOrdersHistory()->getInvoiceItemQtyToInvoiceInput($product['name'])->getValue(),
				"Invoice Popup - Product ".$product['name']."'s qty to invoice is wrong"
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
		return "Order History - Invoice - Popup Display: Pass";
	}
}