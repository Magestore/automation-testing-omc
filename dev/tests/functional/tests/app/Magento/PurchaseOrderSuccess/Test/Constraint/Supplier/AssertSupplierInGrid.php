<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/27/2017
 * Time: 8:07 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Supplier;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Fixture\Supplier;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierIndex;

class AssertSupplierInGrid extends AbstractConstraint
{
    /**
     * Filters array mapping.
     *
     * @var array
     */
    private $filter;

    public function processAssert(
        Supplier $supplier,
        SupplierIndex $supplierIndex
    ) {
        $supplierIndex->open();
        $data = $supplier->getData();
        $this->filter = ['supplier_code' => $data['supplier_code']];
        $supplierIndex->getSupplierGridBlock()->search($this->filter);

        \PHPUnit_Framework_Assert::assertTrue(
            $supplierIndex->getSupplierGridBlock()->isRowVisible($this->filter, false, false),
            'Supplier is absent in Supplier grid'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            count($supplierIndex->getSupplierGridBlock()->getAllIds()),
            1,
            'There is more than one supplier founded'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Supplier is present in grid.';
    }
}