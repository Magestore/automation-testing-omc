<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/1/2018
 * Time: 3:32 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertInvoiceDontAllowInvoiceItems
 * @package Magento\Webpos\Test\Constraint\OrderHistory\Invoice
 */
class AssertInvoiceDontAllowInvoiceItems extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     * @param $products
     */
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        if(!$webposIndex->getOrderHistoryInvoice()->isVisible()){
            $webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
            $webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
        }
        $rowTotal = 0;
        foreach ($products as $item){
            $productName = $item['product']->getName();
            $rowTotal += (float) substr($webposIndex->getOrderHistoryInvoice()->getRowTotalOfProduct($productName)->getText(), 1);
        }

        \PHPUnit_Framework_Assert::assertEquals(
            0,
            $rowTotal,
            'Row total is not 0.'
        );

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