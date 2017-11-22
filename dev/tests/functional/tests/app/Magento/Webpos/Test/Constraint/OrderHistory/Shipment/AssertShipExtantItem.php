<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/10/2017
 * Time: 15:00
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Shipping\Test\Page\Adminhtml\SalesShipmentView;
use Magento\Shipping\Test\Page\Adminhtml\ShipmentIndex;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShipExtantItem extends AbstractConstraint
{
	public function processAssert(
		WebposIndex $webposIndex,
		ShipmentIndex $shipmentIndex,
		SalesShipmentView $salesShipmentView,
		AssertShipmentCreateSuccess $assertShipmentCreateSuccess,
		AssertShipmentInBackend $assertShipmentInBackend,
		$products,
		$orderId
	)
	{
		$webposIndex->open();
		while(!$webposIndex->getCheckoutPage()->getProductList()->isVisible()) {}

		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->ordersHistory();
		$webposIndex->getOrdersHistory()->search($orderId);

		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		$webposIndex->getOrdersHistory()->getAction('Ship')->click();

		$webposIndex->getOrdersHistory()->getShipSummitButton()->click();
		$webposIndex->getModal()->getOkButton()->click();

		$assertShipmentCreateSuccess->processAssert($webposIndex, 'Complete', false);

		for ($i = 0; $i < sizeof($products); $i++) {
			$products[$i]['ship_qty'] = $products[$i]['qty'] - $products[$i]['ship_qty'];
		}

		$assertShipmentInBackend->processAssert($shipmentIndex, $salesShipmentView, $products, $orderId);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Shipment - Ship Extant Items: Pass";
	}
}