<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/11/2017
 * Time: 09:27
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\TaxClass;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxClassIsShownOnTaxClassField extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $taxClass, $action = "")
	{
		$webposIndex->open();
		sleep(1);
		$webposIndex->getCheckoutPage()->getCustomSaleButton()->click();
		$webposIndex->getCheckoutPage()->clickCustomSaleSelectTaxClass();
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->getCustomSaleTaxClassItem($taxClass)->isVisible(),
			'Synchronization - Tax Classes - '.$action.' - Tax Class is not shown on tax class field'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Tax Classes - Tax Class is shown correctly on tax class field";
	}
}