<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/28/2017
 * Time: 7:50 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase\Supplier;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Fixture\Supplier;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierIndex;

class MassChangeStatusSupplierEntityTest extends Injectable
{
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var SupplierIndex
     */
    protected  $supplierIndex;

    /**
     * @param FixtureFactory $fixtureFactory
     * @param SupplierIndex $supplierIndex
     */
    public function __inject(
        FixtureFactory $fixtureFactory,
        SupplierIndex $supplierIndex
    ){
        $this->fixtureFactory = $fixtureFactory;
        $this->supplierIndex = $supplierIndex;
    }

    public function test($suppliersQty, $supplierDataSet, $status)
    {
        $suppliers = $this->createSuppliers($suppliersQty, $supplierDataSet);
        $massActionSuppliers = [];
        foreach ($suppliers as $supplier) {
            $massActionSuppliers[] = ['supplier_code' => $supplier->getSupplierCode()];
        }
        $this->supplierIndex->open();
        $this->supplierIndex->getSupplierGridBlock()->massaction($massActionSuppliers, $status, true);

        return ['suppliers' => $suppliers];
    }

    public function createSuppliers($suppliersQty, $supplierDataSet)
    {
        /**
         * @var Supplier[] $suppliers
         */
        $suppliers = [];
        for ($i = 0; $i < $suppliersQty; $i++) {
            $supplier = $this->fixtureFactory->createByCode('supplier', ['dataset' => $supplierDataSet]);
            $supplier->persist();
            $suppliers[] = $supplier;
        }

        return $suppliers;
    }
}