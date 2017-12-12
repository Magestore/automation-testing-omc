<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/12/2017
 * Time: 13:45
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\EditQty;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertEditProductPopupIsAvailable extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->isVisible(),
			'Checkout - Cart - Edit product popup is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getProductImage()->isVisible(),
			'Checkout - Cart - Edit product popup - Product Image is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getQtyInput()->isVisible(),
			'Checkout - Cart - Edit product popup - Qty textbox is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getDescQtyButton()->isVisible(),
			'Checkout - Cart - Edit product popup - Desc qty button is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getIncQtyButton()->isVisible(),
			'Checkout - Cart - Edit product popup - Inc qty button is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->isVisible(),
			'Checkout - Cart - Edit product popup - Custom price button is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->isVisible(),
			'Checkout - Cart - Edit product popup - Discount button is not shown'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Checkout - Cart - Edit product popup is avalable";
	}
}