<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/28/2017
 * Time: 9:14 AM
 */
namespace Magento\PurchaseOrderSuccess\Test\Constraint\ReturnOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\ReturnOrderNew;

class AssertReturnOrderSuccessSaveMessage extends AbstractConstraint
{
    const SUCCESS_SAVE_MESSAGE = 'Return request has been saved.';

    public function processAssert(ReturnOrderNew $returnOrderNew)
    {
        $returnOrderNew->getReturnOrderForm()->waitPageToLoad();
        $actualMessage = $returnOrderNew->getMessagesBlock()->getSuccessMessage();
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
        return 'Return request success create message is present.';
    }
}