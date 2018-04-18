<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/27/2017
 * Time: 8:29 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Supplier;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierNew;

class AssertRequireMessagesVisible extends AbstractConstraint
{
    public function processAssert(SupplierNew $supplierNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->requireFieldErrorsIsVisible('supplier_code'),
            'Supplier Code require error is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->requireFieldErrorsIsVisible('supplier_name'),
            'Supplier Name require error is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->requireFieldErrorsIsVisible('contact_name'),
            'Contact Person require error is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $supplierNew->getSupplierForm()->requireFieldErrorsIsVisible('contact_email'),
            'Email require error is not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Require errors is visible.';
    }
}