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
 * Class AssertInvoiceAllOfInvoiceItemsAvailable
 * @package Magento\Webpos\Test\Constraint\OrderHistory\Invoice
 */
class AssertInvoiceAllOfInvoiceItemsAvailable extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $products
     */
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        foreach ($products as $item){
            $productName = $item['product']->getName();
            $qtyOfProduct = (float) $webposIndex->getOrderHistoryInvoice()->getItemQtyToInvoiceInput($productName)->getValue();
            \PHPUnit_Framework_Assert::assertEquals(
                $item['orderQty'],
                $qtyOfProduct,
                'Qty to Invoice is not correctly.'
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