<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/1/2018
 * Time: 2:32 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertInvoiceAllowInvoiceItems
 * @package Magento\Webpos\Test\Constraint\OrderHistory\Invoice
 */
class AssertInvoiceAllowInvoiceItems extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     * @param $products
     * @param $totalPaid
     */
    public function processAssert(WebposIndex $webposIndex, $products, $totalPaid = null)
    {
        $rowTotal = 0;
        foreach ($products as $item){
            $productName = $item['product']->getName();
            $rowTotal += (float) substr($webposIndex->getOrderHistoryInvoice()->getRowTotalOfProduct($productName)->getText(), 1);
        }

        \PHPUnit_Framework_Assert::assertGreaterThan(
            0,
            $rowTotal,
            'Row total is not greater than 0.'
        );
        if ($totalPaid != null) {
            \PHPUnit_Framework_Assert::assertLessThan(
                $totalPaid,
                $rowTotal,
                'No have invoice items that have Row total less than total paid.'
            );
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Invoice was correctly";
    }
}