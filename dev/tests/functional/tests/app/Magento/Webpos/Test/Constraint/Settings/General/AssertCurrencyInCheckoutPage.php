<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/09/2017
 * Time: 14:59
 */

namespace Magento\Webpos\Test\Constraint\Settings\General;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCurrencyInCheckoutPage extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, CatalogProductSimple $product, $rate, $symbol, $result)
	{
		$webposIndex->open();
		$webposIndex->getCheckoutPage()->search($product->getSku());
		$price = $webposIndex->getCheckoutPage()->getFirstProduct()->find('.price')->getText();
		$price = str_replace($symbol, '', $price);
		\PHPUnit_Framework_Assert::assertEquals(
			(float) $price,
			(float) $result['before-price'] * $rate,
			'Checkout page - Product Price - Currency rate is wrong'
		);
		$total = $webposIndex->getCheckoutPage()->getTotal2();
		$total = str_replace($symbol, '', $total);
		\PHPUnit_Framework_Assert::assertEquals(
			(float) $result['before-total'] * $rate,
			(float) $total,
			'Checkout page - Total Price - Currency rate is wrong'
		);

		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->ordersHistory();
		$webposIndex->getOrdersHistory()->search($result['before-orderId']);
		$orderHistoryPrice = $webposIndex->getOrdersHistory()->getPrice();
		$orderHistoryPrice = str_replace($symbol, '', $orderHistoryPrice);
		\PHPUnit_Framework_Assert::assertEquals(
			(float) $result['before-orderHistory-price'] * $rate,
			(float) $orderHistoryPrice,
			'Order History page - Order History - Total Price - Currency rate is wrong'
		);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Frontend - Setting - General - Currency : Pass";
	}
}