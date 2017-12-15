<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 04/12/2017
 * Time: 15:50
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCartPageIsDefault extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getCheckoutCartItems()->getFirstCartItem()->isVisible(),
			'Cart page - Order Item is not empty'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			(float) 0,
			(float) substr($webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Subtotal')->getText(),1),
			"Cart Page - SubTotal != 0"
		);
		\PHPUnit_Framework_Assert::assertEquals(
			(float) 0,
			(float) substr($webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Total')->getText(),1),
			"Cart Page - Total != 0"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Cart page is default";
	}
}