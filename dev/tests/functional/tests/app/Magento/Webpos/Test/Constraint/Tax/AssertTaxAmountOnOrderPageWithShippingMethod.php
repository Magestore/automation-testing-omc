<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/8/2018
 * Time: 4:31 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;


use Magento\Mtf\Constraint\AbstractAssertForm;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertTaxAmountOnOrderPageWithShippingMethod
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountOnOrderPageWithShippingMethod extends AbstractAssertForm
{

    /**
     * @param $taxRate
     * @param $shippingFee
     * @param $products
     * @param WebposIndex $webposIndex
     */
    public function processAssert($taxRate, $shippingFee, $products, WebposIndex $webposIndex)
    {
        $taxRate = (float) $taxRate / 100;
        $subtotalWholeCart = 0;
        $taxAmountWholeCart = 0;
        $discountAmountWholeCart = 0;

        foreach ($products as $item) {
            $productName = $item['product']->getName();
            $subtotalOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getSubtotalOfProduct($productName);
            $subtotalOfProduct = (float)substr($subtotalOfProduct,1);

            $taxAmountOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getTaxAmountOfProduct($productName);
            $taxAmountOfProduct = (float)substr($taxAmountOfProduct,1);

            $discountAmountOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getDiscountAmountOfProduct($productName);
            $discountAmountOfProduct = (float)substr($discountAmountOfProduct,1);

            $rowTotalOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName);
            $rowTotalOfProduct = (float)substr($rowTotalOfProduct,1);

            $taxAmount = ($subtotalOfProduct - $discountAmountOfProduct) * $taxRate;
            $rowTotal = $subtotalOfProduct + $taxAmountOfProduct - $discountAmountOfProduct;

            $subtotalWholeCart += $subtotalOfProduct;
            $taxAmountWholeCart += $taxAmountOfProduct;
            $discountAmountWholeCart += $discountAmountOfProduct;

//            \PHPUnit_Framework_Assert::assertEquals(
//                $taxAmount,
//                $taxAmountOfProduct,
//                'On the Orders Historys - The Tax Amount was not correctly at '.$productName
//            );
//            \PHPUnit_Framework_Assert::assertEquals(
//                $rowTotal,
//                $rowTotalOfProduct,
//                'On the Orders Historys - The Row Total was not correctly at '.$productName
//            );
        }

//        $subtotalWholeCartOnPage = $webposIndex->getOrderHistoryOrderViewFooter()->getRowValue('Subtotal');
//        $subtotalWholeCartOnPage = (float)substr($subtotalWholeCartOnPage,1);
//
//        $shippingWholeCartOnPage = $webposIndex->getOrderHistoryOrderViewFooter()->getRowValue('Shipping');
//        $shippingWholeCartOnPage = (float)substr($shippingWholeCartOnPage,1);

        if($taxAmountWholeCart != 0){
            $taxAmountWholeCart += $shippingFee * $taxRate / (1 + $taxRate);
            $taxAmountWholeCart = round($taxAmountWholeCart, 2);
            $taxAmountWholeCartOnPage = $webposIndex->getOrderHistoryOrderViewFooter()->getRowValue('Tax');
            $taxAmountWholeCartOnPage = (float)substr($taxAmountWholeCartOnPage,1);
            \PHPUnit_Framework_Assert::assertEquals(
                $taxAmountWholeCart,
                $taxAmountWholeCartOnPage,
                'On the Orders History - The Tax Amount whole cart was not correctly'
            );
        }

//        $grandTotalWholeCartOnPage = $webposIndex->getOrderHistoryOrderViewFooter()->getRowValue('Grand Total');
//        $grandTotalWholeCartOnPage = (float)substr($grandTotalWholeCartOnPage,1);
//
//        $grandTotalWholeCart = $subtotalWholeCart + $shippingWholeCartOnPage + $taxAmountWholeCart - $discountAmountWholeCart;
//
//        \PHPUnit_Framework_Assert::assertEquals(
//            $subtotalWholeCart,
//            $subtotalWholeCartOnPage,
//            'On the Orders Historys - The Subtotal whole cart was not correctly'
//        );
//        \PHPUnit_Framework_Assert::assertEquals(
//            $grandTotalWholeCart,
//            $grandTotalWholeCartOnPage,
//            'On the Orders Historys - The Grand Total whole cart was not correctly'
//        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History Page - The Tax at the web POS was correctly";
    }
}