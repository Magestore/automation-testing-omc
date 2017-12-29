<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/28/2017
 * Time: 10:39 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Quotation;

use Magento\PurchaseOrderSuccess\Test\Fixture\Quotation;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertQuotationInGrid
 * @package Magento\PurchaseOrderSuccess\Test\Constraint\Quotation
 */
class AssertQuotationInGrid extends AbstractConstraint
{

    /**
     * @param Quotation $quotation
     * @param QuotationIndex $quotationIndex
     */
    public function processAssert(Quotation $quotation, QuotationIndex $quotationIndex)
    {
        $quotationIndex->open();
        $filter = [
            'supplier_id' => $quotation->getData('supplier_id'),
        ];
        $errorMessage = implode(', ', $filter);
        $quotationIndex->getQuotationGrid()->search($filter);
        \PHPUnit_Framework_Assert::assertTrue(
            $quotationIndex->getQuotationGrid()->isRowVisible($filter, false, false),
            'Quotation with '
            . $errorMessage
            . 'is absent in Quotation grid.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Quotation is present in grid.';
    }
}