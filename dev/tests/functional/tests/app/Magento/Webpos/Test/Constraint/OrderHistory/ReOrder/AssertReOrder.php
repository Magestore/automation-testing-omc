<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 05/10/2017
 * Time: 11:05
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\ReOrder;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertReOrder extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $products)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->isVisible(),
			"Didn't redirect to checkout page"
		);
		foreach ($products as $product) {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getCheckoutPage()->getCartItem($product['name'])->isVisible(),
				"Cart Item ".$product['name'].": missed"
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$product['name'],
				$webposIndex->getCheckoutPage()->getCartItemName($product['name']),
				"Cart Item's name is wrong"
			);
			if ($product['qty'] > 1) {
				\PHPUnit_Framework_Assert::assertEquals(
					$product['qty'],
					(int) $webposIndex->getCheckoutPage()->getCartItemQty($product['name'])->getText(),
					"Cart Item ".$product['name']."'s qty is wrong".
					"Expected: ". $product['qty'].
					"Actual: ". $webposIndex->getCheckoutPage()->getCartItemQty($product['name'])->getText()
				);
			}
		}

	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Re-Order: Pass";
	}
}