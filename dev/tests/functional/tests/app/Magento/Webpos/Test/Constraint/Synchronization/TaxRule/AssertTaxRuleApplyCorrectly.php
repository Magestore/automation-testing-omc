<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/11/2017
 * Time: 13:31
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\TaxRule;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxRuleApplyCorrectly extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, Customer $customer, $taxClass, $taxRate, $action = '')
	{
		$webposIndex->open();
		// Change Customer
		$webposIndex->getCheckoutPage()->getChangeCustomerIcon()->click();
		$webposIndex->getCheckoutPage()->searchCustomer($customer->getEmail());
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->getFirstCustomer()->isVisible(),
			'Synchronization - Tax Rule - '.$action.' - Not found customer'
		);
		$webposIndex->getCheckoutPage()->getFirstCustomer()->click();
		sleep(1);

		// Add custom product with product class
		$webposIndex->getCheckoutPage()->getCustomSaleButton()->click();
		$productName = 'custom product' . mt_rand(1, 999999);
		$price = 100;
		$webposIndex->getCheckoutPage()->getCustomSaleProductNameInput()->setValue($productName);
		$webposIndex->getCheckoutPage()->getCustomSaleProductPriceInput()->setValue($price);
		$webposIndex->getCheckoutPage()->clickCustomSaleSelectTaxClass();
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->getCustomSaleTaxClassItem($taxClass)->isVisible(),
			'Synchronization - Tax Rule - '.$action.' - Tax class "'.$taxClass.'" is not shown on tax class list'
		);
		$webposIndex->getCheckoutPage()->getCustomSaleTaxClassItem($taxClass)->click();
		$webposIndex->getCheckoutPage()->getCustomSaleAddToCartButton()->click();
		sleep(1);

		$subTotal = $webposIndex->getCheckoutPage()->getSubTotal();
		$subTotal = (float) substr($subTotal, 1);
		$expectTax = $subTotal * ($taxRate/100);
		$tax = $webposIndex->getCheckoutPage()->getTax();
		$tax = (float) substr($tax, 1);
		\PHPUnit_Framework_Assert::assertEquals(
			(float) $expectTax,
			(float) $tax,
			'Synchronization - Tax Rule - '.$action.' - tax is not calulated base corresponding tax rate'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Tax Rule - Tax rule apply correctly:  tax is calulated base corresponding tax rate ";
	}
}