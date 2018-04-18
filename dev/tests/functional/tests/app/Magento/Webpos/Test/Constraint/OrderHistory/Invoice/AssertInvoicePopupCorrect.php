<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/1/2018
 * Time: 8:17 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertInvoicePopupCorrect extends AbstractConstraint
{

    public function processAssert(WebposIndex $webposIndex, $products, $labels)
    {
        foreach ($products as $item){
            $productName = $item['Product'];
            \PHPUnit_Framework_Assert::assertEquals(
                $item['Price'],
                $webposIndex->getOrderHistoryInvoice()->getProductPrice($productName),
                "Price of " . $productName . " was not correctly."
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $item['Qty'],
                $webposIndex->getOrderHistoryInvoice()->getQtyOfProduct($productName)->getText(),
                "Qty of " . $productName . " was not correctly."
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $item['Subtotal'],
                $webposIndex->getOrderHistoryInvoice()->getSubtotalOfProduct($productName)->getText(),
                "Subtotal of " . $productName . " was not correctly."
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $item['Tax Amount'],
                $webposIndex->getOrderHistoryInvoice()->getTaxAmountOfProduct($productName)->getText(),
                "Tax of " . $productName . " was not correctly."
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $item['Discount Amount'],
                $webposIndex->getOrderHistoryInvoice()->getDiscountAmountOfProduct($productName)->getText(),
                "Discount of " . $productName . " was not correctly."
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $item['Row Total'],
                $webposIndex->getOrderHistoryInvoice()->getRowTotalOfProduct($productName)->getText(),
                "Row total of " . $productName . " was not correctly."
            );
        }
        \PHPUnit_Framework_Assert::assertEquals(
            $labels['Subtotal'],
            $webposIndex->getOrderHistoryInvoice()->getSubtotal(),
            "Subtotal on Invoice popup was not correctly."
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $labels['Shipping'],
            $webposIndex->getOrderHistoryInvoice()->getRowValue('Shipping & Handling'),
            "Shipping on Invoice popup was not correctly."
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $labels['Tax'],
            $webposIndex->getOrderHistoryInvoice()->getRowValue('Tax'),
            "Tax on Invoice popup was not correctly."
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $labels['Discount'],
            $webposIndex->getOrderHistoryInvoice()->getRowValue('Discount'),
            "Discount on Invoice popup was not correctly."
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $labels['Grand Total'],
            $webposIndex->getOrderHistoryInvoice()->getRowValue('Grand Total'),
            "Grand Total on Invoice popup was not correctly."
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Invoice Popup was correctly";
    }
}