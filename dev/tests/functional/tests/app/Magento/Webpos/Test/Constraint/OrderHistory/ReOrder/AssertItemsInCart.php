<?php

/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/25/2018
 * Time: 3:55 PM
 */
namespace Magento\Webpos\Test\Constraint\OrderHistory\ReOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertItemsInCart
 * @package Magento\Webpos\Test\Constraint\OrderHistory\ReOrder
 */
class AssertItemsInCart extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     * @param $products
     * @param null $taxRate
     * @param bool $discount
     */
    public function processAssert(WebposIndex $webposIndex, $products, $taxRate = null, $discount = false)
    {
        foreach ($products as $item) {
            $productName = $item['product']->getName();
            \PHPUnit_Framework_Assert::assertEquals(
                $productName,
                $webposIndex->getCheckoutCartItems()->getCartItemName($productName),
                'Name of "' . $productName . '" was not correctly.'
            );

            if(isset($item['orderQty']) && $item['orderQty'] > 1){
                $productQty = (float) $item['orderQty'];
                $qtyOfProduct = (float) $webposIndex->getCheckoutCartItems()->getCartItemQty($productName)->getText();
                \PHPUnit_Framework_Assert::assertEquals(
                    $productQty,
                    $qtyOfProduct,
                    'Qty of "' . $productName . '" was not correctly.'
                );
            }

            if(isset($item['customPrice']) && isset($item['orderQty'])){
                $sumProductPrice = (float) $item['orderQty'] * $item['customPrice'];
                $priceOfProduct = $webposIndex->getCheckoutCartItems()->getCartItemPrice($productName)->getText();
                $priceOfProduct = (float) substr($priceOfProduct, 1);
                \PHPUnit_Framework_Assert::assertEquals(
                    $sumProductPrice,
                    $priceOfProduct,
                    'Price of "' . $productName . '" was not correctly.'
                );
            }
            if(isset($taxRate)){
                $taxRate = (float) $taxRate / 100;
                $taxAmountOnPage = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Tax")->getText();
                $taxAmountOnPage = (float)substr($taxAmountOnPage,1);
                \PHPUnit_Framework_Assert::assertNotEquals(
                    0,
                    $taxAmountOnPage,
                    'Tax Amount on cart was not correctly.'
                );
            }
            if($discount){
                \PHPUnit_Framework_Assert::assertFalse(
                    $webposIndex->getCheckoutCartFooter()->getDiscount()->isVisible(),
                    'Discount on cart was visible.'
                );
            }
        }
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Re-Order on checkout cart page was correctly.";
    }
}