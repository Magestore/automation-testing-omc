<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/12/2018
 * Time: 3:42 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertTaxAmountOnOrderHistoryInvoiceWithShippingFee
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountOnOrderHistoryInvoiceWithShippingFee extends AbstractConstraint
{

    /**
     * @param $taxRate
     * @param $shippingFee
     * @param $products
     * @param WebposIndex $webposIndex
     */
    public function processAssert($taxRate, $shippingFee, $products, WebposIndex $webposIndex)
    {
        $taxRate = (float)$taxRate / 100;
        $subtotalWholeCart = 0;
        $taxAmountWholeCart = 0;
        $discountAmountWholeCart = 0;

        foreach ($products as $item) {
            $productName = $item['product']->getName();
            $subtotalOfProduct = $webposIndex->getOrderHistoryInvoice()->getSubtotalOfProduct($productName)->getText();
            $subtotalOfProduct = (float)substr($subtotalOfProduct, 1);

            $taxAmountOfProduct = $webposIndex->getOrderHistoryInvoice()->getTaxAmountOfProduct($productName)->getText();
            $taxAmountOfProduct = (float)substr($taxAmountOfProduct, 1);

            $discountAmountOfProduct = $webposIndex->getOrderHistoryInvoice()->getDiscountAmountOfProduct($productName)->getText();
            $discountAmountOfProduct = (float)substr($discountAmountOfProduct, 1);

            $rowTotalOfProduct = $webposIndex->getOrderHistoryInvoice()->getRowTotalOfProduct($productName)->getText();
            $rowTotalOfProduct = (float)substr($rowTotalOfProduct, 1);

            $taxAmount = ($subtotalOfProduct - $discountAmountOfProduct) * $taxRate;
	        $taxAmount = round($taxAmount, 2);
            $rowTotal = $subtotalOfProduct + $taxAmountOfProduct - $discountAmountOfProduct;

            $subtotalWholeCart += $subtotalOfProduct;
            $taxAmountWholeCart += $taxAmountOfProduct;
            $discountAmountWholeCart += $discountAmountOfProduct;

            \PHPUnit_Framework_Assert::assertEquals(
                $taxAmount,
                $taxAmountOfProduct,
                'On the Order History Invoice - The Tax Amount was not correctly at ' . $productName
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $rowTotal,
                $rowTotalOfProduct,
                'On the Order History Invoice - The Row Total was not correctly at ' . $productName
            );
        }

        $subtotalWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Subtotal');
        $subtotalWholeCartOnPage = (float)substr($subtotalWholeCartOnPage, 1);

        $shippingWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Shipping & Handling');
        $shippingWholeCartOnPage = (float)substr($shippingWholeCartOnPage, 1);

        $taxAmountWholeCart += $shippingFee * $taxRate / (1 + $taxRate);
        $taxAmountWholeCart = round($taxAmountWholeCart, 2);

        $taxAmountWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Tax');
        $taxAmountWholeCartOnPage = (float)substr($taxAmountWholeCartOnPage, 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmountWholeCart,
            $taxAmountWholeCartOnPage,
            'On the Order History Invoice - The Tax Amount whole cart was not correctly'
        );

        $discountWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Discount');
        $discountWholeCartOnPage = (float)substr($discountWholeCartOnPage, 2);

        $grandTotalWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Grand Total');
        $grandTotalWholeCartOnPage = (float)substr($grandTotalWholeCartOnPage, 1);

        $grandTotalWholeCart = $subtotalWholeCart + $shippingWholeCartOnPage + $taxAmountWholeCart - $discountWholeCartOnPage;

        \PHPUnit_Framework_Assert::assertEquals(
            $subtotalWholeCart,
            $subtotalWholeCartOnPage,
            'On the Order History Invoice - The Subtotal whole cart was not correctly'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $grandTotalWholeCart,
            $grandTotalWholeCartOnPage,
            'On the Order History Invoice - The Grand Total whole cart was not correctly'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "The Tax Amount on Order History Invoice was correctly.";
    }
}