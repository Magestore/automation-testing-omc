<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 08:23
 */

namespace Magento\Webpos\Test\Constraint\Checkout\MultiOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposMultiOrderAddSomeProductsAndCustomerCP32
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Constraint\CategoryRepository\MultiOrder
 */
class AssertWebposMultiOrderAddSomeProductsAndCustomerCP32 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products, $firstOrder, $orderNumber, $customerName)
    {
        foreach ($products as $product) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->isVisible(),
                'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass - The cart item with product name\'s'.$product->getName().' was not visible.'
            );
        }

        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getCheckoutCartHeader()->getMultiOrderItem($orderNumber)->isVisible(),
            'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass - The cart item with name\'s'.$orderNumber.' was visible. Because We just using cart 2nd to checkout so the cart we have it is cart 1nd.'
        );

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartHeader()->getMultiOrderItem($firstOrder)->isVisible(),
            'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass - The cart item with name\'s'.$firstOrder.' was not visible.'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            $customerName,
            $webposIndex->getCheckoutWebposCart()->getCustomerTitleHeaderPage()->getText(),
            'After CategoryRepository On 2nd cart. we have just one cart. It is 1nd cart but It is not visible correctly.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass - The cart item were visible successfully.';
    }
}