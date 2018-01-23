<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 19/01/2018
 * Time: 13:56
 */

namespace Magento\Webpos\Test\Constraint\Tax;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertTaxAmountOnOrderHistoryInvoiceWithTaxApplyToFPT
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountOnOrderHistoryInvoiceWithTaxApplyToFPT extends AbstractConstraint
{
	/**
	 * @param WebposIndex $webposIndex
	 * @param $products
	 * @param $taxRate
	 */
	public function processAssert(WebposIndex $webposIndex, $products, $taxRate)
	{
		$taxRate = (float) $taxRate / 100;
		$subtotalOnPage = $webposIndex->getOrderHistoryInvoice()->getSubtotal();
		$subtotalOnPage = (float)substr($subtotalOnPage,1);
		if($webposIndex->getOrderHistoryInvoice()->getFooterRow('Discount')->isVisible()){
			$discountOnPage = $webposIndex->getOrderHistoryInvoice()->getFooterRow("Discount")->getText();
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
		$taxAmountOnPage = $webposIndex->getOrderHistoryOrderViewFooter()->getTax();
		$taxAmountOnPage = (float)substr($taxAmountOnPage,1);

		\PHPUnit_Framework_Assert::assertEquals(
			$taxAmount,
			$taxAmountOnPage,
			'[Apply Tax To FPT] = Yes - Order History - Invoice - Tax amount was not correctly.'
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
		return '[Apply Tax To FPT] = Yes - Order History - Invoice - Tax amount is correct';
	}
}