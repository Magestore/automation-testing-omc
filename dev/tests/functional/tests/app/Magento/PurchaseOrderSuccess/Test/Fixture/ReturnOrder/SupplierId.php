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
    protected $supplier;
    protected $data;

    public function __construct(FixtureFactory $fixtureFactory,array $params,$data )
    {
        $this->params = $params;

        if ( isset($data['dataset']) )
        {
                $supplier = $fixtureFactory->createByCode('supplier', ['dataset' => $data['dataset']]);

                if (!$supplier->hasData('supplier_id'))
                {
                    $supplier->persist();
                }
                $this->supplier = $supplier;

                $this->data = $supplier->getSupplierName();
        }
    }


    public function getSupplier()
    {
        return $this->supplier;
    }
}