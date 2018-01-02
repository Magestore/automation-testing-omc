<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/28/2017
 * Time: 10:29 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Supplier;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierIndex;

class AssertSupplierMassChangeStatusSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after change status via mass actions
     */
    const SUCCESS_CHANGE_STATUS_MESSAGE = '%d record(s) have been %s' . 'd.';

    /**
     * Assert that message "%d record(s) have been %s."
     *
     * @param $suppliersQty
     * @param SupplierIndex $supplierIndex
     * @return void
     */
    public function processAssert($suppliersQty, $status, SupplierIndex $supplierIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_CHANGE_STATUS_MESSAGE, $suppliersQty, strtolower($status)),
            $supplierIndex->getMessagesBlock()->getSuccessMessage(),
            'Wrong ' . $status . ' message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Mass change status supplier message is displayed.';
    }
}