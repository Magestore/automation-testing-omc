<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/28/2017
 * Time: 8:33 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Supplier;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierIndex;

class AssertSupplierMassDeteteSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after deletion via mass actions
     */
    const SUCCESS_DELETE_MESSAGE = '%d record(s) have been deleted.';

    /**
     * Assert that message "A total of "x" record(s) were deleted."
     *
     * @param $suppliersQtyToDelete
     * @param SupplierIndex $supplierIndex
     * @return void
     */
    public function processAssert($suppliersQtyToDelete, SupplierIndex $supplierIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_DELETE_MESSAGE, $suppliersQtyToDelete),
            $supplierIndex->getMessagesBlock()->getSuccessMessage(),
            'Wrong supplier delete message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Mass delete supplier message is displayed.';
    }
}