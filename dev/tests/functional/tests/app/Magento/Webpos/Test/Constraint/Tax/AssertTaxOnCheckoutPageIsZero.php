<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/01/2018
 * Time: 16:26
 */

namespace Magento\Webpos\Test\Constraint\Tax;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxOnCheckoutPageIsZero extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{

		$taxAmount = 0;
		$taxAmountOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Tax")->getText();
		$taxAmountOnPage = (float)substr($taxAmountOnPage,1);

		\PHPUnit_Framework_Assert::assertEquals(
			$taxAmount,
			$taxAmountOnPage,
			'On the Cart - The Tax was not updated to 0'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Tax on checkout page was updated to 0";
	}
}