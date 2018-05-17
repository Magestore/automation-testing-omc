<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/12/2017
 * Time: 14:15
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\EditQty;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertEditProductPopupIsClosed
 * @package Magento\Webpos\Test\Constraint\Cart\CartPage\EditQty
 */
class AssertEditProductPopupIsClosed extends AbstractConstraint
{

	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getCheckoutProductEdit()->isVisible(),
			'CategoryRepository - TaxClass Page - Product edit popup is not closed'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "CategoryRepository - TaxClass Page - Product edit popup is closed";
	}
}