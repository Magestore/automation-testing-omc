<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 12/12/2017
 * Time: 14:58
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\EditQty;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertProductQtyOnCartIsCorrect
 * @package Magento\Webpos\Test\Constraint\Cart\CartPage\EditQty
 */
class AssertProductQtyOnCartIsCorrect extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param CatalogProductSimple $product
     * @param $expectQty
     */
	public function processAssert(WebposIndex $webposIndex, CatalogProductSimple $product, $expectQty)
	{
		if ($expectQty == 1) {
			\PHPUnit_Framework_Assert::assertFalse(
				$webposIndex->getCheckoutCartItems()->getCartItemQty($product->getName())->isVisible(),
				"CategoryRepository - TaxClass - Product - Qty number is not hide"
			);
		} else {
			\PHPUnit_Framework_Assert::assertEquals(
				$expectQty,
				$webposIndex->getCheckoutCartItems()->getCartItemQty($product->getName())->getText(),
				"CategoryRepository - TaxClass - Qty of product on cart is wrong"
				. "\nExpected: " . $expectQty
				. "\nActual: " . $webposIndex->getCheckoutCartItems()->getCartItemQty($product->getName())->getText()
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
		return "CategoryRepository - TaxClass - Qty of product on cart is correct";
	}
}