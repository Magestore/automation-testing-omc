<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/27/2017
 * Time: 1:23 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase\Supplier;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierIndex;

class MassActionDeleteSupplierEntityTest extends Injectable
{
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var SupplierIndex
     */
    protected $supplierIndex;

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
        $supplierIndex->open();
        $supplierIndex->getSupplierGridBlock()->massaction([], 'Delete', true, 'Select All');
    }

    public function test($suppliersQty, $suppliersQtyToDelete)
    {
        $suppliers = $this->createSuppliers($suppliersQty);
        $deleteSuppliers = [];
        for ($i = 0; $i < $suppliersQtyToDelete; $i++) {
            $deleteSuppliers[] = ['supplier_code' => $suppliers[$i]->getSupplierCode()];
        }
        $this->supplierIndex->open();
        $this->supplierIndex->getSupplierGridBlock()->massaction($deleteSuppliers, 'Delete', true);

        return ['suppliers' => $suppliers];
    }

    public function createSuppliers($suppliersQty)
    {
        $suppliers = [];
        for ($i = 0; $i < $suppliersQty; $i++) {
            $supplier = $this->fixtureFactory->createByCode('supplier', ['dataset' => 'supplier_with_require_fields']);
            $supplier->persist();
            $suppliers[] = $supplier;
        }
        return $suppliers;
    }

}