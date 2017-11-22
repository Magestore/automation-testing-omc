<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/10/2017
 * Time: 16:26
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Product;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductIsInProductList extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, CatalogProductSimple $product, $action = '')
	{
		$webposIndex->open();
		sleep(3);
		$webposIndex->getCheckoutPage()->search($product->getName());
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->getFirstProduct()->isVisible(),
			'Synchronization - Product - '.$action.' - Product name is not updated'
		);
		$webposIndex->getCheckoutPage()->search($product->getSku());
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->getFirstProduct()->isVisible(),
			'Synchronization - Product - '.$action.' - Product SKU is not updated'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			(float)$product->getPrice(),
			(float) $webposIndex->getCheckoutPage()->getFirstProductPrice(),
			'Synchronization - Product - '.$action.' - Product Price is not updated'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Product - Product is display correctly in product list";
	}
}