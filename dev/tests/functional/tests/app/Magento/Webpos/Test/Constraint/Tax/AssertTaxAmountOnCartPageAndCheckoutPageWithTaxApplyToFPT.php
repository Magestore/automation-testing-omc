<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/01/2018
 * Time: 10:24
 */

namespace Magento\Webpos\Test\Constraint\Tax;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxAmountOnCartPageAndCheckoutPageWithTaxApplyToFPT extends AbstractConstraint
{
	public function processAssert($taxRate, $products, WebposIndex $webposIndex)
	{
		$taxRate = (float) $taxRate / 100;
		$subtotalOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Subtotal")->getText();
		$subtotalOnPage = (float)substr($subtotalOnPage,1);
		if($webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Discount")->isVisible()){
			$discountOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Discount")->getText();
			$discountOnPage = (float)substr($discountOnPage,2);
		}else{
			$discountOnPage = 0;
		}

		$fptPrice = 0;
		foreach ($products as $item) {
			$fptPrice += $item['product']->getFpt()[0]['price'] * $item['orderQty'];
		}

		$taxAmount = (float) ($subtotalOnPage - $discountOnPage + $fptPrice) * $taxRate;
		$taxAmount = round($taxAmount, 2);
		$taxAmountOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Tax")->getText();
		$taxAmountOnPage = (float)substr($taxAmountOnPage,1);

		\PHPUnit_Framework_Assert::assertEquals(
			$taxAmount,
			$taxAmountOnPage,
			'[Apply Tax To FPT] = Yes - On the Cart - The Tax at the web POS was not correctly.'
			. "\nExpect: " . $taxAmount
			. "\nActual: " . $taxAmountOnPage
		);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "The Tax with Tax apply to FPT at cart was correctly.";
	}
}