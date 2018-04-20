<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 13/12/2017
 * Time: 13:11
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\EditQty;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertMinimumQtyAllowWarningMessageIsCorrect extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, CatalogProductSimple $product)
	{
		$message = "The fewest you may purchase is 1";
		\PHPUnit_Framework_Assert::assertEquals(
			sprintf($message, $product->getName()),
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			'CategoryRepository - TaxClass - Edit Product Qty - Minimum qty allow warning message is wrong'
			. "\nExpected: " . sprintf($message)
			. "\nActual: " . $webposIndex->getToaster()->getWarningMessage()->getText()
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "CategoryRepository - TaxClass - Edit Product Qty - Minimum qty allow warning message is correct";
	}
}