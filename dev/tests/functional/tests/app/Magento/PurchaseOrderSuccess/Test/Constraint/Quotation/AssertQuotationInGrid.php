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
        $filter = [
            'supplier_id' => $quotation->getData('supplier_id'),
            'purchased_at[from]' => $quotation->getData('purchased_at'),
            'purchased_at[to]' => $quotation->getData('purchased_at'),
        ];
        if ($quotation->hasData('total_qty_orderred')) {
            $filter['total_qty_orderred[from]'] = $quotation->getData('total_qty_orderred');
            $filter['total_qty_orderred[to]'] = $quotation->getData('total_qty_orderred');
        }
        if ($quotation->hasData('grand_total_incl_tax')) {
            $filter['grand_total_incl_tax[from]'] = $quotation->getData('grand_total_incl_tax');
            $filter['grand_total_incl_tax[to]'] = $quotation->getData('grand_total_incl_tax');
        }
        $quotationIndex->open();
        $quotationIndex->getQuotationGrid()->search($filter);
        $errorMessage = implode(', ', $filter);
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