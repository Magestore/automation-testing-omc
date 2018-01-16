<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 15/01/2018
 * Time: 10:12
 */

namespace Magento\Webpos\Test\Constraint\Tax;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxAmountOnOrderHistoryInvoiceWithShipExcludeTax extends AbstractConstraint
{
	/**
	 * @param $taxRate
	 * @param $products
	 * @param WebposIndex $webposIndex
	 */
	public function processAssert($taxRate, $products, WebposIndex $webposIndex)
	{
		$taxRate = (float) $taxRate / 100;
		$subtotalWholeCart = 0;
		$shippingWholeCart = 0;
		$taxAmountWholeCart = 0;
		$discountAmountWholeCart = 0;
		$grandTotalWholeCart = 0;

		foreach ($products as $item) {
			$productName = $item['product']->getName();
			$subtotalOfProduct = $webposIndex->getOrderHistoryInvoice()->getSubtotalOfProduct($productName)->getText();
			$subtotalOfProduct = (float)substr($subtotalOfProduct,1);

			$taxAmountOfProduct = $webposIndex->getOrderHistoryInvoice()->getTaxAmountOfProduct($productName)->getText();
			$taxAmountOfProduct = (float)substr($taxAmountOfProduct,1);

			$discountAmountOfProduct = $webposIndex->getOrderHistoryInvoice()->getDiscountAmountOfProduct($productName)->getText();
			$discountAmountOfProduct = (float)substr($discountAmountOfProduct,1);

			$rowTotalOfProduct = $webposIndex->getOrderHistoryInvoice()->getRowTotalOfProduct($productName)->getText();
			$rowTotalOfProduct = (float)substr($rowTotalOfProduct,1);

			$taxAmount = ($subtotalOfProduct - $discountAmountOfProduct) * $taxRate;
			$rowTotal = $subtotalOfProduct + $taxAmountOfProduct - $discountAmountOfProduct;

			$subtotalWholeCart += $subtotalOfProduct;
//            $taxAmountWholeCart += $taxAmountOfProduct;
			$discountAmountWholeCart += $discountAmountOfProduct;

			\PHPUnit_Framework_Assert::assertEquals(
				$taxAmount,
				$taxAmountOfProduct,
				'Orders History - The Tax Amount was not correctly at '.$productName
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$rowTotal,
				$rowTotalOfProduct,
				'Orders History - The Row Total was not correctly at '.$productName
			);
		}

		$subtotalWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Subtotal');
		$subtotalWholeCartOnPage = (float)substr($subtotalWholeCartOnPage,1);

		$shippingWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Shipping & Handling');
		$shippingWholeCartOnPage = (float)substr($shippingWholeCartOnPage,1);

		$taxAmountWholeCart = ($subtotalWholeCartOnPage + $shippingWholeCartOnPage - $discountAmountWholeCart) * $taxRate;

		if($taxAmountWholeCart != 0){
			$taxAmountWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Tax');
			$taxAmountWholeCartOnPage = (float)substr($taxAmountWholeCartOnPage,1);
			\PHPUnit_Framework_Assert::assertEquals(
				$taxAmountWholeCart,
				$taxAmountWholeCartOnPage,
				'Orders History - The Tax Amount whole cart was not correctly'
			);
		}

		$grandTotalWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Grand Total');
		$grandTotalWholeCartOnPage = (float)substr($grandTotalWholeCartOnPage,1);

		$grandTotalWholeCart = $subtotalWholeCart + $shippingWholeCartOnPage + $taxAmountWholeCart - $discountAmountWholeCart;

		\PHPUnit_Framework_Assert::assertEquals(
			$subtotalWholeCart,
			$subtotalWholeCartOnPage,
			'Orders History - The Subtotal whole cart was not correctly'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$grandTotalWholeCart,
			$grandTotalWholeCartOnPage,
			'Orders History - The Grand Total whole cart was not correctly'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Setting [Tax Class for Shipping] = Taxable goods and Shipping excluding tax - Order History - The Tax Amount on Invoice Popup was correctly.";
	}
}