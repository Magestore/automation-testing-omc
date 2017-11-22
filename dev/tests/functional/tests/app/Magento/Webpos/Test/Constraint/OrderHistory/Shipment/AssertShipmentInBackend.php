<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/10/2017
 * Time: 10:40
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Shipping\Test\Page\Adminhtml\SalesShipmentView;
use Magento\Shipping\Test\Page\Adminhtml\ShipmentIndex;

class AssertShipmentInBackend extends AbstractConstraint
{
	public function processAssert(
		ShipmentIndex $shipmentIndex,
		SalesShipmentView $salesShipmentView,
		$products,
		$orderId
	)
	{
		$shipmentIndex->open();
		\PHPUnit_Framework_Assert::assertTrue(
			$shipmentIndex->getShipmentsGrid()->isRowVisible(['order_id' => $orderId], true, false),
			'Shipment for Order '.$orderId." hasn't created"
		);

		$shipmentIndex->getShipmentsGrid()->resetFilter();
		$shipmentIndex->getShipmentsGrid()->sortGridByField('Shipment', 'desc');
		$shipmentIndex->getShipmentsGrid()->searchAndOpen(['order_id' => $orderId]);
		$data = $salesShipmentView->getItemsBlock()->getData();
		foreach ($products as $product) {
			if ($product['ship_qty'] > 0) {
				$key = array_search($product['name'], array_column($data, 'product'));
				\PHPUnit_Framework_Assert::assertNotFalse(
					$key,
					'Product '.$product['name'].' is absent'
				);
				\PHPUnit_Framework_Assert::assertEquals(
					(int) $product['ship_qty'],
					(int) $data[$key]['qty'],
					"Product ".$product['name']." - ship qty is wrong"
				);
			}
		}
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Shipment has been created in backend";
	}
}