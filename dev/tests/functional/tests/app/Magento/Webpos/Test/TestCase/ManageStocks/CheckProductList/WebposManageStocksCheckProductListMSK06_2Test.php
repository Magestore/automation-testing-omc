<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 15/03/2018
 * Time: 07:48
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks\CheckProductList;


use Magento\InventorySuccess\Test\Fixture\Warehouse;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStocksCheckProductListMSK06_2Test extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	public function __prepare()
	{
		//Config create session before working
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'create_section_before_working_yes_MS57']
		)->run();
	}

	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
	}

	public function test(
		Location $location,
		Pos $pos,
		Staff $staff,
		Warehouse $warehouse,
		$productList
	)
	{
		$location->persist();

		$pos = $this->preparePos($pos, $location->getLocationId());
		$pos->persist();

		$staff = $this->prepareStaff($staff, $location->getLocationId(), $pos->getPosId());
		$staff->persist();

		$warehouse = $this->prepareWarehouse($warehouse, $location->getLocationId());
		$warehouse->persist();

		// Create product
		$productList = $this->createProducts($productList, $warehouse->getWarehouseId());

		// LoginTest webpos
		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
			[
				'staff' => $staff,
				'location' => $location,
				'pos' => $pos
			]
		)->run();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		sleep(2);

		$searchText = $productList[2]['product']->getName();
		$this->webposIndex->getManageStockList()->searchProduct($searchText);

		return [
			'productList' => $productList,
			'productInfo' => $productList[2]
		];
	}

	public function tearDown()
	{
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'create_section_before_working_no_MS57']
		)->run();
	}

	/**
	 * @param Warehouse $warehouse
	 * @param $locationId
	 * @return Warehouse
	 */
	protected function prepareWarehouse(Warehouse $warehouse, $locationId)
	{
		$data = $warehouse->getData();
		$data['location_id'] = $locationId;

		return $this->fixtureFactory->createByCode('warehouse', ['data' => $data]);
	}

	/**
	 * @param Pos $pos
	 * @param $locationId
	 * @return Pos
	 */
	protected function preparePos(Pos $pos, $locationId)
	{
		$data = $pos->getData();
        $data['location_id'] = array();
        $data['location_id'][] = $locationId;
		return $this->fixtureFactory->createByCode('pos', ['data' => $data]);
	}

	/**
	 * @param Staff $staff
	 * @param $locationId
	 * @param $posId
	 * @return Staff
	 */
	protected function prepareStaff(Staff $staff, $locationId, $posId)
	{
		$data = $staff->getData();
        $data['location_id'] = array();
        $data['location_id'][] = $locationId;

        $data['pos_ids'] = array();
        $data['pos_ids'][] = $posId;

		return $this->fixtureFactory->createByCode('staff', ['data' => $data]);
	}

	protected function createProducts($productList, $warehouseId) {
		foreach ($productList as $key => $item) {
			$product = $this->fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $item['product']]);
			$data = $product->getData();

			if (isset($item['qty'])) {
				$data['warehouse_stock']['warehouse_stock_row'][0]['total_qty'] = $item['qty'];
			}

			if (isset($item['inStock'])) {
				if ($item['inStock']) {
					$data['quantity_and_stock_status']['is_in_stock'] = 'In Stock';
				} else {
					$data['quantity_and_stock_status']['is_in_stock'] = 'Out of Stock';
				}
			}

			$data['warehouse_stock']['warehouse_stock_row'][0]['warehouse_select'] = $warehouseId;

			$product = $this->fixtureFactory->createByCode('catalogProductSimple', ['data' => $data]);

			$id = $this->objectManager->create('Magento\Catalog\Test\Handler\CatalogProductSimple\Curl')->persist($product);
			$data = array_merge($product->getData(), $id);

			$productList[$key]['product'] = $this->fixtureFactory->createByCode('catalogProductSimple', ['data' => $data]);
		}

		return $productList;
	}
}