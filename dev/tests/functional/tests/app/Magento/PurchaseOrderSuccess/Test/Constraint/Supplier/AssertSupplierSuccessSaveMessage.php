<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/25/2017
 * Time: 8:57 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Supplier;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierNew;

class AssertSupplierSuccessSaveMessage extends AbstractConstraint
{
    const SUCCESS_SAVE_MESSAGE = 'The supplier information has been saved.';

    public function processAssert(SupplierNew $supplierNew)
    {
        $supplierNew->getSupplierForm()->waitPageToLoad();
        $actualMessage = $supplierNew->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_SAVE_MESSAGE,
            $actualMessage,
            'Wrong success save message is displayed.'
            . "\nExpected: " . self::SUCCESS_SAVE_MESSAGE
            . "\nActual: " . $actualMessage
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Supplier success create message is present.';
    }
}