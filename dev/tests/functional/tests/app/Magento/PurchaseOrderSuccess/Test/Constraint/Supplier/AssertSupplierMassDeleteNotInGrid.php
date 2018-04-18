<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/28/2017
 * Time: 8:37 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Supplier;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Fixture\Supplier;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierIndex;

class AssertSupplierMassDeleteNotInGrid extends AbstractConstraint
{
    /**
     *
     * @param SupplierIndex $supplierIndex
     * @param int $suppliersQtyToDelete
     * @param Supplier[] $suppliers
     * @return void
     */
    public function processAssert(
        SupplierIndex $supplierIndex,
        $suppliersQtyToDelete,
        $suppliers
    ) {
        for ($i = 0; $i < $suppliersQtyToDelete; $i++) {
            \PHPUnit_Framework_Assert::assertFalse(
                $supplierIndex->getSupplierGridBlock()->isRowVisible(['supplier_code' => $suppliers[$i]->getSupplierCode()]),
                'Supplier with code ' . $suppliers[$i]->getSupplierCode() . 'is present in Supplier grid.'
            );
        }
    }

    /**
     * Success message if Supplier not in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Deleted suppliers are absent in Supplier grid.';
    }
}