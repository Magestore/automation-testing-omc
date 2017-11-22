<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/10/2017
 * Time: 08:06
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundExtandItems extends AbstractConstraint
{
	public function processAssert(
		WebposIndex $webposIndex,
		AssertRefundPopupDisplay $assertRefundPopupDisplay,
		AssertRefundSuccess $assertRefundSuccess,
		$products
	)
	{
		if (!$webposIndex->getOrdersHistory()->getActionsBox()->isVisible()) {
			$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		}

		$webposIndex->getOrdersHistory()->getAction('Refund')->click();

		$productList = [];
		foreach ($products as $product) {
			$qty = $product['qty'] - $product['refund_qty'];
			if ($qty > 0) {
				$productList[] = [
					'name' => $product['name'],
					'qty' => $qty
				];
			}
		}
		$assertRefundPopupDisplay->processAssert($webposIndex, $productList);

		$webposIndex->getOrdersHistory()->getRefundSubmitButton()->click();
		$webposIndex->getModal()->getOkButton()->click();

		$expextStatus = 'Closed';
		$hideAction = 'Ship,Refund,Cancel';
		$totalRefunded = null;

		$assertRefundSuccess->processAssert($webposIndex, $expextStatus, $hideAction, $totalRefunded);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Refund - Refund Extant Items: Success";
	}
}