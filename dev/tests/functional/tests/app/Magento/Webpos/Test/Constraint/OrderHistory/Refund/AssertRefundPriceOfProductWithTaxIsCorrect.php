<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 16/01/2018
 * Time: 08:53
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundPriceOfProductWithTaxIsCorrect extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $products, $taxRate = 0)
	{
		$taxRate = (float) $taxRate / 100;

		foreach ($products as $item) {
			$productName = $item['product']->getName();
			$priceOfProduct = $webposIndex->getOrderHistoryRefund()->getItemPrice($productName);
			$priceOfProduct = substr($priceOfProduct, 1);
			$expectPriceOfProduct = (float) $item['product']->getPrice() * (1 + $taxRate);
			$expectPriceOfProduct = round($expectPriceOfProduct, 2);

			\PHPUnit_Framework_Assert::assertEquals(
				$expectPriceOfProduct,
				$priceOfProduct,
				'Order History - Refund Popup - Price of product '. $productName. ' (with tax) is wrong'
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
		return "Order History - Refund Popup - Price of each product (with tax) is correct";
	}
}