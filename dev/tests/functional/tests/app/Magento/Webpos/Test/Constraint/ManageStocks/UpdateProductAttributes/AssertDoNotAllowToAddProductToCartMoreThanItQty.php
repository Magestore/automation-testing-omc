<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/03/2018
 * Time: 09:25
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertDoNotAllowToAddProductToCartMoreThanItQty extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		$message = "We don't have as many \"%s\" as you requested. The current in-stock qty is \"%d\"";

		\PHPUnit_Framework_Assert::assertStringMatchesFormat(
			$message,
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			"Manage Stock - Still allow to add product with more than it's qty to cart"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stock - Don't allow to add product with more than it's qty to cart";
	}
}