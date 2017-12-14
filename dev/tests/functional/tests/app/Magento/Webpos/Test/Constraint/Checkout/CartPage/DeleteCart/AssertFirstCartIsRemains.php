<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/12/2017
 * Time: 15:38
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\DeleteCart;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertFirstCartIsRemains extends AbstractConstraint
{

	public function processAssert(WebposIndex $webposIndex, CatalogProductSimple $product)
	{
		$webposIndex->getCheckoutCartHeader()->getMultiOrderItem(1)->click();
		$webposIndex->getMsWebpos()->waitCartLoader();
		$webposIndex->getMsWebpos()->waitCheckoutLoader();

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutCartItems()->getFirstCartItem()->isVisible(),
			'First Cart is empty'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			(float) $product->getPrice(),
			(float) substr($webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Subtotal')->getText(), 1),
			"Checkout - Cart Page - First cart's Subtotal is wrong"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			(float) $product->getPrice(),
			(float) substr($webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Total')->getText(), 1),
			"Checkout - Cart Page - First cart's Total is wrong"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Checkout - Cart Page - First cart is remains";
	}
}