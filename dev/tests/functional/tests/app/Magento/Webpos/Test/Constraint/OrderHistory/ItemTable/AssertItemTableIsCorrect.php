<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/01/2018
 * Time: 13:57
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\ItemTable;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertItemTableIsCorrect extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $products, $discountAmount, CatalogProductSimple $catalogProductSimple)
	{
		foreach ($products as $item) {
			$productName = $item['product']->getName();
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getOrderHistoryOrderViewContent()->getProductRow($productName)->isVisible(),
				'Item table - Product "'.$productName.'" is not shown'
			);

			\PHPUnit_Framework_Assert::assertEquals(
				$item['product']->getSku(),
				$webposIndex->getOrderHistoryOrderViewContent()->getProductSKU($productName)->getText(),
				'Item table - SKU of Product "'.$productName.'" is wrong'
			);

			$originalPrice = (float) $item['product']->getPrice();
			$originalPriceOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getOriginalPriceOfProduct($productName)->getText();
			$originalPriceOnPage = (float)substr($originalPriceOnPage, 1);
			\PHPUnit_Framework_Assert::assertEquals(
				$originalPrice,
				$originalPriceOnPage,
				'Item table - Product "'.$productName.'" - Original Price is wrong'
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
				'Item table - Product "'.$productName.'" - Price is wrong'
			);

			if (isset($item['qtyText'])) {
				\PHPUnit_Framework_Assert::assertEquals(
					$item['qtyText'],
					$webposIndex->getOrderHistoryOrderViewContent()->getQtyOfProduct($productName)->getText(),
					'Item table - Product "'.$productName.'" - Qty is wrong'
				);
			}

			$subTotal = (float)($price * $item['orderQty']);
			$subTotalOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getSubTotalOfProduct($productName);
			$subTotalOnPage = (float)substr($subTotalOnPage, 1);
			\PHPUnit_Framework_Assert::assertEquals(
				$subTotal,
				$subTotalOnPage,
				'Item table - Product "'.$productName.'" - SubTotal is wrong'
			);

			$taxOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getTaxAmountOfProduct($productName);
			$taxOnPage = (float)substr($taxOnPage, 1);
			\PHPUnit_Framework_Assert::assertNotEmpty(
				$taxOnPage,
				'Item table - Product "'.$productName.'" - Tax is not shown'
			);

			$subTotalWholeCart = $webposIndex->getOrderHistoryOrderViewFooter()->getSubtotal();
			$subTotalWholeCart = (float)substr($subTotalWholeCart, 1);

			$discountOfProduct = (float) (($subTotal / $subTotalWholeCart) * (float)$discountAmount);
			$discountOfProduct = round($discountOfProduct, 2);
			$discountOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getDiscountAmountOfProduct($productName);
			$discountOnPage = (float)substr($discountOnPage, 1);
			\PHPUnit_Framework_Assert::assertEquals(
				$discountOfProduct,
				$discountOnPage,
				'Item table - Product "'.$productName.'" - Discount amount is wrong'
			);
			$rowTotal = (float)($subTotal + $taxOnPage - (float)$discountAmount);
			$rowTotalOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName);
			$rowTotalOnPage = (float)substr($rowTotalOnPage, 1);
			\PHPUnit_Framework_Assert::assertEquals(
				$rowTotal,
				$rowTotalOnPage,
				'Item table - Product "'.$productName.'" - Row Total is wrong'
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
		return "Orders History - Item Table is displayed correctly";
	}
}