<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/18/2017
 * Time: 8:51 AM
 */

namespace Magento\Storepickup\Test\Fixture\Store;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class WarehouseId extends DataSource
{
    protected $warehouse;

    public function __construct(
        FixtureFactory $fixtureFactory,
        array $params,
        array $data = []
    ) {
        $this->params = $params;
        if (isset($data['dataset']) && $data['dataset'] !== '-') {
            $dataset = $data['dataset'];
            $warehouse = $fixtureFactory->createByCode('warehouse', ['dataset' => trim($dataset)]);
            if (!$warehouse->hasData('warehouse_id')) {
                $warehouse->persist();
            }
            $this->warehouse = $warehouse;
            $this->data = $warehouse->getWarehouseName() . '(' . $warehouse->getWarehouseCode() . ')';

        }
    }

    /**
     * Return warehouse.
     *
     * @return array
     */
    public function getWarehouse()
    {
        return $this->warehouse;
    }
}