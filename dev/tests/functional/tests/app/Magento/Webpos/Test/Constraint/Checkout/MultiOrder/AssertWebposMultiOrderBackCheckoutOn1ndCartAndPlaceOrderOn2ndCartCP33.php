<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 09:08
 */

namespace Magento\Webpos\Test\Constraint\Checkout\MultiOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposMultiOrderBackCheckoutOn1ndCartAndPlaceOrderOn2ndCartCP33
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Constraint\CategoryRepository\MultiOrder
 */
class AssertWebposMultiOrderBackCheckoutOn1ndCartAndPlaceOrderOn2ndCartCP33 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products, $firstOrder, $secondOrder)
    {
        foreach ($products as $product) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->isVisible(),
                'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass - The cart item with product name\'s'.$product->getName().' was not visible.'
            );
            break;
        }

        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getCheckoutCartHeader()->getMultiOrderItem($secondOrder)->isVisible(),
            'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass - The cart item with name\'s'.$secondOrder.' was visible. Because We just using cart 2nd to checkout so the cart we have it is cart 1nd.'
        );

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartHeader()->getMultiOrderItem($firstOrder)->isVisible(),
            'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass - The cart item with name\'s'.$firstOrder.' was not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass - AssertWebposCheckGUICustomerPriceCP54 MultiOrder Back CategoryRepository On 1nd TaxClass And Place Order On 2nd TaxClass were worked correctly.';
    }
}