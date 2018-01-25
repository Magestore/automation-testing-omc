<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/01/2018
 * Time: 13:57
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\ItemTable;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertItemTableIsCorrectTaxBeforeDiscount extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $products, $taxRate, $discountAmount)
	{
		$taxRate = (float) $taxRate/100;
		foreach ($products as $item) {
			$productName = $item['product']->getName();
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getOrderHistoryOrderViewContent()->getProductRow($productName)->isVisible(),
				'Item table - Tax before discount - Product "'.$productName.'" is not shown'
			);

			\PHPUnit_Framework_Assert::assertEquals(
				$item['product']->getSku(),
				$webposIndex->getOrderHistoryOrderViewContent()->getProductSKU($productName)->getText(),
				'Item table - Tax before discount - SKU of Product "'.$productName.'" is not wrong'
			);

			if (isset($item['customPrice'])) {
				$price = (float) $item['customPrice'];
			} else {
				$price = (float) $item['product']->getPrice();
			}
			$priceOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getPriceOfProduct($productName)->getText();
			$priceOnPage = (float)substr($priceOnPage, 1);

			\PHPUnit_Framework_Assert::assertEquals(
				$price,
				$priceOnPage,
				'Item table - Tax before discount - Product "'.$productName.'" - Price is wrong'
			);

			if (isset($item['qtyText'])) {
				\PHPUnit_Framework_Assert::assertEquals(
					$item['qtyText'],
					$webposIndex->getOrderHistoryOrderViewContent()->getQtyOfProduct($productName)->getText(),
					'Item table - Tax before discount - Product "'.$productName.'" - Qty is wrong'
				);
			}

			$subTotal = (float)($price * $item['orderQty']);
			$subTotalOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getSubTotalOfProduct($productName);
			$subTotalOnPage = (float)substr($subTotalOnPage, 1);
			\PHPUnit_Framework_Assert::assertEquals(
				$subTotal,
				$subTotalOnPage,
				'Item table - Tax before discount - Product "'.$productName.'" - SubTotal is wrong'
			);

			$tax = (float) $subTotal * $taxRate;
			$tax = round($tax, 2);
			$taxOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getTaxAmountOfProduct($productName);
			$taxOnPage = (float)substr($taxOnPage, 1);
			\PHPUnit_Framework_Assert::assertEquals(
				$tax,
				$taxOnPage,
				'Item table - Tax before discount - Product "'.$productName.'" - Tax is wrong'
			);

			$discountOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getDiscountAmountOfProduct($productName);
			$discountOnPage = (float)substr($discountOnPage, 1);
			\PHPUnit_Framework_Assert::assertEquals(
				(float)$discountAmount,
				$discountOnPage,
				'Item table - Tax before discount - Product "'.$productName.'" - Discount amount is wrong'
			);
			$rowTotal = (float)($subTotal + $tax - (float)$discountAmount);
			$rowTotalOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName);
			$rowTotalOnPage = (float)substr($rowTotalOnPage, 1);
			\PHPUnit_Framework_Assert::assertEquals(
				$rowTotal,
				$rowTotalOnPage,
				'Item table - Tax before discount - Product "'.$productName.'" - Row Total is wrong'
			);
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Orders History - Tax before discount - Item Table is displayed correctly";
	}
}