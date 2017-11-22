<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/10/2017
 * Time: 10:04
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertStockQtyUpdated extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $products)
	{
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->manageStocks();

		sleep(1);
		foreach ($products as $product) {
			\PHPUnit_Framework_Assert::assertEquals(
				(int) $product['qty_before_refund'] + (int) $product['refund_qty'],
				(int) $webposIndex->getManageStocks()->getQtyInputByName($product['name'])->getValue(),
				"Qty of product '".$product['name']."' is not updated"
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
		return "Order History - Refund - Return to stock - item's stock qty updated";
	}
}