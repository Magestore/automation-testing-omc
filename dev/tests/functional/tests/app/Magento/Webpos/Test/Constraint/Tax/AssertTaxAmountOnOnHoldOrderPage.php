<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/5/2018
 * Time: 4:47 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertTaxAmountOnCartPageAndCheckoutPage
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountOnOnHoldOrderPage extends AbstractConstraint
{

    /**
     * @param $taxRate
     * @param $products
     * @param WebposIndex $webposIndex
     */
    public function processAssert($taxRate, $products, WebposIndex $webposIndex)
    {
        $taxRate = (float) $taxRate / 100;
        $subtotalWholeCart = 0;
        $shippingWholeCart = 0;
        $taxAmountWholeCart = 0;
        $discountAmountWholeCart = 0;
        $grandTotalWholeCart = 0;

        foreach ($products as $item) {
            $productName = $item['product']->getName();
            $subtotalOfProduct = $webposIndex->getOnHoldOrderOrderViewContent()->getSubtotalOfProduct($productName)->getText();
            $subtotalOfProduct = (float)substr($subtotalOfProduct,1);

            $taxAmountOfProduct = $webposIndex->getOnHoldOrderOrderViewContent()->getTaxAmountOfProduct($productName)->getText();
            $taxAmountOfProduct = (float)substr($taxAmountOfProduct,1);

            $discountAmountOfProduct = $webposIndex->getOnHoldOrderOrderViewContent()->getDiscountAmountOfProduct($productName)->getText();
            $discountAmountOfProduct = (float)substr($discountAmountOfProduct,1);

            $rowTotalOfProduct = $webposIndex->getOnHoldOrderOrderViewContent()->getRowTotalOfProduct($productName)->getText();
            $rowTotalOfProduct = (float)substr($rowTotalOfProduct,1);

            $taxAmount = $subtotalOfProduct * $taxRate;
            $rowTotal = $subtotalOfProduct + $taxAmountOfProduct - $discountAmountOfProduct;

            $subtotalWholeCart += $subtotalOfProduct;
            $taxAmountWholeCart += $taxAmountOfProduct;
            $discountAmountWholeCart += $discountAmountOfProduct;

            \PHPUnit_Framework_Assert::assertEquals(
                $taxAmount,
                $taxAmountOfProduct,
                'On the On-Hold Orders - The Tax Amount was not correctly at '.$productName
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $rowTotal,
                $rowTotalOfProduct,
                'On the On-Hold Orders - The Row Total was not correctly at '.$productName
            );
        }

        $subtotalWholeCartOnPage = $webposIndex->getOnHoldOrderOrderViewFooter()->getRowValue('Subtotal');
        $subtotalWholeCartOnPage = (float)substr($subtotalWholeCartOnPage,1);

        $shippingWholeCartOnPage = $webposIndex->getOnHoldOrderOrderViewFooter()->getRowValue('Shipping');
        $shippingWholeCartOnPage = (float)substr($shippingWholeCartOnPage,1);

        if($taxAmountWholeCart != 0){
            $taxAmountWholeCartOnPage = $webposIndex->getOnHoldOrderOrderViewFooter()->getRowValue('Tax');
            $taxAmountWholeCartOnPage = (float)substr($taxAmountWholeCartOnPage,1);
            \PHPUnit_Framework_Assert::assertEquals(
                $taxAmountWholeCart,
                $taxAmountWholeCartOnPage,
                'On the On-Hold Orders - The Tax Amount whole cart was not correctly'
            );
        }

        $grandTotalWholeCartOnPage = $webposIndex->getOnHoldOrderOrderViewFooter()->getRowValue('Grand Total');
        $grandTotalWholeCartOnPage = (float)substr($grandTotalWholeCartOnPage,1);

        $grandTotalWholeCart = $subtotalWholeCart + $shippingWholeCartOnPage + $taxAmountWholeCart - $discountAmountWholeCart;

        \PHPUnit_Framework_Assert::assertEquals(
            $subtotalWholeCart,
            $subtotalWholeCartOnPage,
            'On the On-Hold Orders - The Subtotal whole cart was not correctly'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $grandTotalWholeCart,
            $grandTotalWholeCartOnPage,
            'On the On-Hold Orders - The Grand Total whole cart was not correctly'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "The Tax Amount on On-Hold Orders was correctly.";
    }
}