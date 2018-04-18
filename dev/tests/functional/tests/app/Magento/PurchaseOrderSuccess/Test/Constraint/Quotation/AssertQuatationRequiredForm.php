<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/28/2017
 * Time: 1:26 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Quotation;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationNew;


class AssertQuatationRequiredForm extends AbstractConstraint
{

    /**
     * @param QuotationNew $quotationNew
     */
    public function processAssert(QuotationNew $quotationNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $quotationNew->getQuotationForm()->fieldErrorIsVisible(),
            'Quotation required field form is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Quotation form is available.';
    }
}