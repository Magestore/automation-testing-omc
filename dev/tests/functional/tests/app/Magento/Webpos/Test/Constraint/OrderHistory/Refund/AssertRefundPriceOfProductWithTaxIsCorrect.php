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

/**
 * Class AssertRefundPriceOfProductWithTaxIsCorrect
 * @package Magento\Webpos\Test\Constraint\SectionOrderHistory\Refund
 */
class AssertRefundPriceOfProductWithTaxIsCorrect extends AbstractConstraint
{
	/**
	 * @param WebposIndex $webposIndex
	 * @param $products
	 * @param int $taxRate
	 * @param bool $useCustomPrice
	 */
	public function processAssert(WebposIndex $webposIndex, $products, $taxRate = 0, $useCustomPrice = false)
	{
		$taxRate = (float) $taxRate / 100;

		foreach ($products as $item) {
			$productName = $item['product']->getName();
			$priceOfProduct = $webposIndex->getOrderHistoryRefund()->getItemPrice($productName);
			$priceOfProduct = substr($priceOfProduct, 1);
			if ($useCustomPrice) {
				$price = (float) $item['customPrice'];
			} else {
				$price = (float) $item['product']->getPrice();
			}
			$expectPriceOfProduct =  $price * (1 + $taxRate);
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