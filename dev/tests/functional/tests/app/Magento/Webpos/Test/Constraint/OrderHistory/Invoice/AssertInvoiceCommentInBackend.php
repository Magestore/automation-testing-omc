<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/1/2018
 * Time: 10:49 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Sales\Test\Page\Adminhtml\SalesInvoiceView;
use Magento\Sales\Test\Page\Adminhtml\InvoiceIndex;

/**
 * Class AssertInvoiceCommentInBackend
 * @package Magento\Webpos\Test\Constraint\OrderHistory\Invoice
 */
class AssertInvoiceCommentInBackend extends AbstractConstraint
{
    /**
     * @param InvoiceIndex $invoiceIndex
     * @param SalesInvoiceView $saleInvoiceView
     * @param $orderId
     * @param $invoiceComment
     */
    public function processAssert(
        InvoiceIndex $invoiceIndex,
        SalesInvoiceView $saleInvoiceView,
        $orderId,
        $invoiceComment
    ){
        $invoiceIndex->open();
        $invoiceIndex->getInvoicesGrid()->searchAndOpen(['order_id' => $orderId]);
        $actualinvoiceComment = $saleInvoiceView->getInvoiceHistoryBlock()->getNoteListComment();
        \PHPUnit_Framework_Assert::assertEquals(
            $invoiceComment,
            $actualinvoiceComment,
            'Invoice comment in backend is wrong.'
            . "\nExpected: " . $invoiceComment
            . "\nActual: " . $actualinvoiceComment
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Invoice Comment in backend was correctly.";
    }
}
