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
/**
 * Class AssertEditProductPopupIsAvailable
 * @package Magento\Webpos\Test\Constraint\Checkout\CartPage\EditQty
 */
class AssertEditProductPopupIsAvailable extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->isVisible(),
			'CategoryRepository - TaxClass - Edit product popup is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getProductImage()->isVisible(),
			'CategoryRepository - TaxClass - Edit product popup - Product Image is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getQtyInput()->isVisible(),
			'CategoryRepository - TaxClass - Edit product popup - Qty textbox is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getDescQtyButton()->isVisible(),
			'CategoryRepository - TaxClass - Edit product popup - Desc qty button is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getIncQtyButton()->isVisible(),
			'CategoryRepository - TaxClass - Edit product popup - Inc qty button is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->isVisible(),
			'CategoryRepository - TaxClass - Edit product popup - Custom price button is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->isVisible(),
			'CategoryRepository - TaxClass - Edit product popup - Discount button is not shown'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "CategoryRepository - TaxClass - Edit product popup is avalable";
	}
}