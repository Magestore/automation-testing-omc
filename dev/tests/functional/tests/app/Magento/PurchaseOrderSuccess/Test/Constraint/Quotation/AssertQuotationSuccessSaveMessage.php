<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/27/2017
 * Time: 10:43 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Quotation;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationView;

class AssertQuotationSuccessSaveMessage extends AbstractConstraint
{
    const SUCCESS_SAVE_MESSAGE = 'Quotation has been saved.';

    public function processAssert(QuotationView $quotationView)
    {
        $quotationView->getQuotationForm()->waitPageToLoad();
        $actualMessage = $quotationView->getMessagesBlock()->getSuccessMessage();
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
        return 'Quotation success create message is present.';
    }
}