<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/28/2017
 * Time: 8:55 AM
 */
namespace Magento\PurchaseOrderSuccess\Test\Fixture\ReturnOrder;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class SupplierId extends DataSource
{
    /**
     * @var $supplier
     */
    protected $supplier;

    /**
     * SupplierId constructor.
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param $data
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [] )
    {
        $this->params = $params;
        if (isset($data['dataset'])) {
            $supplier = $fixtureFactory->createByCode('supplier', ['dataset' => $data['dataset']]);
            $supplier->persist();
            $this->data = $supplier->getSupplierName();
            $this->supplier = $supplier;
        }
    }

    /**
    * @return mixed
    */
    public function getSupplier()
    {
        return $this->supplier;
    }
}