<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/28/2017
 * Time: 8:44 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Supplier;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Fixture\Supplier;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierIndex;

class AssertSupplierMassDeleteInGrid extends AbstractConstraint
{
    /**
     *
     * @param SupplierIndex $supplierIndex,
     * @param AssertSupplierInGrid $assertSupplierInGrid
     * @param int $suppliersQtyToDelete
     * @param Supplier[] $suppliers
     * @return void
     */
    public function processAssert(
        SupplierIndex $supplierIndex,
        AssertSupplierInGrid $assertSupplierInGrid,
        $suppliersQtyToDelete,
        $suppliers
    ) {
        $suppliers = array_slice($suppliers, $suppliersQtyToDelete);
        foreach ($suppliers as $supplier) {
            $assertSupplierInGrid->processAssert($supplier, $supplierIndex);
        }
    }

    /**
     * Success message if Supplier in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Supplier are present in Supplier grid.';
    }
}