<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/27/2017
 * Time: 8:23 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Fixture\Quotation;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

/**
 * Class Supplier
 * @package Magento\PurchaseOrderSuccess\Test\Fixture\Quotation
 */
class Supplier extends DataSource
{
    /**
     * @var
     */
    protected $supplier;

    /**
     * Supplier constructor.
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;
        if (isset($data['dataset'])) {
            $supplier = $fixtureFactory->createByCode('supplier', ['dataset' => $data['dataset']]);
            $supplier->persist();
//            $this->data = $supplier->getSupplierId();
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