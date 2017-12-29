<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/28/2017
 * Time: 11:09 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\ReturnOrder;

use Magento\PurchaseOrderSuccess\Test\Fixture\ReturnOrder;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\ReturnOrderIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertReturnOrderSuccessInGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'high';
    /* end tags */

    /**
     * @var ReturnOrderIndex $returnOrderIndex
     */
    protected $returnOrderIndex;

    /**
     * @param ReturnOrder $returnOrder
     * @param ReturnOrderIndex $returnOrderIndex
     */
    public function processAssert(ReturnOrder $returnOrder, ReturnOrderIndex $returnOrderIndex)
    {
        $filter = ['return_code' => $returnOrder->getReturnCode()];
        $returnOrderIndex->open();
        \PHPUnit_Framework_Assert::assertTrue(
            $returnOrderIndex->getReturnOrdersGrid()->isRowVisible($filter),
            'PurchaseOrderSuccess ReturnOrder with ReturnOrder Name \'' . $returnOrder->getReturnCode() . '\' is absent in PurchaseOrderSuccess ReturnOrder grid.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'PurchaseOrderSuccess ReturnOrder is present in PurchaseOrderSuccess ReturnOrder grid.';
    }
}