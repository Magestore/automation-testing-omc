<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 12/12/2017
 * Time: 14:45
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\EditQty;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertValueOfQtyTextboxIsCorrect extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $expectQty)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			$expectQty,
			$webposIndex->getCheckoutProductEdit()->getQtyInput()->getValue(),
			"Checkout - Cart - Product Edit popup - Value of Qty Textbox is wrong"
			. "\nExpected: " . $expectQty
			. "\nActual: " . $webposIndex->getCheckoutProductEdit()->getQtyInput()->getValue()
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Checkout - Cart - Product Edit popup - Value of Qty Textbox is correct";
	}
}