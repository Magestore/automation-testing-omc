<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 15/01/2018
 * Time: 08:30
 */

namespace Magento\Webpos\Test\Constraint\Tax;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxAmountOnOrderDetailPageShipExcludeTax extends AbstractConstraint
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
			$subtotalOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getSubtotalOfProduct($productName);
			$subtotalOfProduct = (float)substr($subtotalOfProduct,1);

			$taxAmountOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getTaxAmountOfProduct($productName);
			$taxAmountOfProduct = (float)substr($taxAmountOfProduct,1);

			$discountAmountOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getDiscountAmountOfProduct($productName);
			$discountAmountOfProduct = (float)substr($discountAmountOfProduct,1);

			$rowTotalOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName);
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

		$subtotalWholeCartOnPage = $webposIndex->getOrderHistoryOrderViewFooter()->getSubtotal();
		$subtotalWholeCartOnPage = (float)substr($subtotalWholeCartOnPage,1);

		$shippingWholeCartOnPage = $webposIndex->getOrderHistoryOrderViewFooter()->getShipping();
		$shippingWholeCartOnPage = (float)substr($shippingWholeCartOnPage,1);

		$taxAmountWholeCart = ($subtotalWholeCartOnPage + $shippingWholeCartOnPage - $discountAmountWholeCart) * $taxRate;

		if($taxAmountWholeCart != 0){
			$taxAmountWholeCartOnPage = $webposIndex->getOrderHistoryOrderViewFooter()->getTax();
			$taxAmountWholeCartOnPage = (float)substr($taxAmountWholeCartOnPage,1);
			\PHPUnit_Framework_Assert::assertEquals(
				$taxAmountWholeCart,
				$taxAmountWholeCartOnPage,
				'Orders History - The Tax Amount whole cart was not correctly'
			);
		}

		$grandTotalWholeCartOnPage = $webposIndex->getOrderHistoryOrderViewFooter()->getGrandTotal();
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
		return "Setting [Tax Class for Shipping] = Taxable goods and Shipping excluding tax - The Tax Amount on Order Detail was correctly.";
	}
}