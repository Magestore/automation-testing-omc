<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/28/2017
 * Time: 10:58 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Supplier;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Fixture\Supplier;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierIndex;

class AssertSupplierMassChangeStatusInGrid extends AbstractConstraint
{
    /**
     * @param Supplier[] $suppliers
     * @param SupplierIndex $supplierIndex
     * @param string $status
     */
    public function processAssert(
        $suppliers,
        SupplierIndex $supplierIndex,
        $status
    ) {
        $supplierIndex->open();
        foreach ($suppliers as $supplier) {
            $filter = [
                'supplier_code' => $supplier->getSupplierCode(),
                'status' => $status
            ];
            $supplierIndex->getSupplierGridBlock()->search($filter);
            \PHPUnit_Framework_Assert::assertTrue(
                $supplierIndex->getSupplierGridBlock()->isRowVisible($filter, false, false),
                'Supplier is absent in Supplier grid'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                count($supplierIndex->getSupplierGridBlock()->getAllIds()),
                1,
                'There is more than one supplier founded'
            );
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Suppliers is present in grid.';
    }
}