<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/17/2018
 * Time: 10:40 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractAssertForm;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertTaxAmountOnOrderPageBeforeDiscount
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountOnOrderPageBeforeDiscount extends AbstractAssertForm
{

    /**
     * @param $taxRate
     * @param $products
     * @param WebposIndex $webposIndex
     */
    public function processAssert($taxRate, $products, WebposIndex $webposIndex)
    {
        $taxRate = (float) $taxRate / 100;
        $taxAmountWholeCart = 0;

        foreach ($products as $item) {
            $productName = $item['product']->getName();
            $subtotalOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getSubtotalOfProduct($productName);
            $subtotalOfProduct = (float)substr($subtotalOfProduct,1);

            $taxAmountOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getTaxAmountOfProduct($productName);
            $taxAmountOfProduct = (float)substr($taxAmountOfProduct,1);

            $taxAmount = $subtotalOfProduct * $taxRate;
            $taxAmount = round($taxAmount, 2);

            $taxAmountWholeCart += $taxAmountOfProduct;

            \PHPUnit_Framework_Assert::assertEquals(
                $taxAmount,
                $taxAmountOfProduct,
                'On the Orders Historys - The Tax Amount was not correctly at '.$productName
            );
        }

        if($taxAmountWholeCart != 0){
            $taxAmountWholeCartOnPage = $webposIndex->getOrderHistoryOrderViewFooter()->getRowValue('Tax');
            $taxAmountWholeCartOnPage = (float)substr($taxAmountWholeCartOnPage,1);
            \PHPUnit_Framework_Assert::assertEquals(
                $taxAmountWholeCart,
                $taxAmountWholeCartOnPage,
                'On the Orders History - The Tax Amount whole cart was not correctly'
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
        return "Order History Page - The Tax at the web POS was correctly";
    }
}