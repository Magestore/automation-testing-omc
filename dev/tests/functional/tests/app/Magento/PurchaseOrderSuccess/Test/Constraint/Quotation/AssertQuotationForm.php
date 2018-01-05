<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/29/2017
 * Time: 4:58 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Quotation;

use Magento\PurchaseOrderSuccess\Test\Fixture\Quotation;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationIndex;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationView;
use Magento\Mtf\Constraint\AbstractAssertForm;



/**
 * Class AssertQuotationForm
 * @package Magento\PurchaseOrderSuccess\Test\Constraint\Quotation
 */
class AssertQuotationForm extends AbstractAssertForm
{

    /**
     * @param Quotation $quotation
     * @param QuotationIndex $quotationIndex
     * @param QuotationView $quotationView
     */
    public function processAssert(Quotation $quotation, QuotationIndex $quotationIndex, QuotationView $quotationView)
    {
        $data = [];

        $data['quotation'] = $quotation->getData();
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
        $quotationIndex->getQuotationGrid()->searchAndOpen($filter);
        $fixtureData = $quotation->getData();
        // continue
        $dataForm = $quotationView->getQuotationViewForm()->getDataQuotation($quotation);
        $error = $this->verifyData($fixtureData, $dataForm);
        \PHPUnit_Framework_Assert::assertTrue(empty($error), $error);
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