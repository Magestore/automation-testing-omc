<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/9/2018
 * Time: 9:12 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;


/**
 * Class AssertTaxAmountOnOrderHistoryInvoiceConfig
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountOnOrderHistoryInvoiceConfig extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     * @param $taxRate
     * @param $products
     * @param bool $discount
     * @param bool $shipping
     */
    public function processAssert(WebposIndex $webposIndex, $taxRate, $products, $discount = false, $shipping = false)
    {
        $taxRate = (float)$taxRate / 100;
        $taxAmountWholeCart = 0;

        foreach ($products as $item) {
            $productName = $item['product']->getName();
            $subtotalOfProduct = $webposIndex->getOrderHistoryInvoice()->getSubtotalOfProduct($productName)->getText();
            $subtotalOfProduct = (float)substr($subtotalOfProduct, 1);

            $taxAmountOfProduct = $webposIndex->getOrderHistoryInvoice()->getTaxAmountOfProduct($productName)->getText();
            $taxAmountOfProduct = (float)substr($taxAmountOfProduct, 1);

            $discountAmountOfProduct = 0;
            if($discount){
                $discountAmountOfProduct = $webposIndex->getOrderHistoryInvoice()->getDiscountAmountOfProduct($productName)->getText();
                $discountAmountOfProduct = (float)substr($discountAmountOfProduct, 1);
            }

            $taxAmount = ($subtotalOfProduct - $discountAmountOfProduct) * $taxRate;
	        $taxAmount = round($taxAmount, 2);

            $taxAmountWholeCart += $taxAmountOfProduct;

            \PHPUnit_Framework_Assert::assertEquals(
                $taxAmount,
                $taxAmountOfProduct,
                'On the Order History Invoice - The Tax Amount was not correctly at ' . $productName
            );
        }

        $discountWholeCartOnPage = 0;
        if($discount){
            $discountWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Discount');
            $discountWholeCartOnPage = (float)substr($discountWholeCartOnPage, 2);
        }

        $shippingFee = 0;
        if ($shipping){
            $shippingFee = $webposIndex->getOrderHistoryInvoice()->getRowValue('Shipping & Handling');
            $shippingFee = (float)substr($shippingFee, 1);
        }

        $taxAmountWholeCart = $taxAmountWholeCart + $shippingFee * $taxRate / (1 + $taxRate) - $discountWholeCartOnPage;
        $taxAmountWholeCart = round($taxAmountWholeCart, 2);

        if($taxAmountWholeCart != 0){
            $taxAmountWholeCartOnPage = $webposIndex->getOrderHistoryInvoice()->getRowValue('Tax');
            $taxAmountWholeCartOnPage = (float)substr($taxAmountWholeCartOnPage,1);
            \PHPUnit_Framework_Assert::assertEquals(
                $taxAmountWholeCart,
                $taxAmountWholeCartOnPage,
                'Orders History - The Tax Amount whole cart was not correctly'
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
        return "The Tax Amount on Order History Invoice was correctly.";
    }
}