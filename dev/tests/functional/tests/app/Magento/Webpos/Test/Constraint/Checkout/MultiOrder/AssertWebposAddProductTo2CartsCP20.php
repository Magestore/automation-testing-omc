<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 16:03
 */

namespace Magento\Webpos\Test\Constraint\Checkout\MultiOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposAddProductTo2CartsCP20
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Constraint\CategoryRepository\MultiOrder
 */
class AssertWebposAddProductTo2CartsCP20 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        $k=0;
        for ($i=1; $i<=2; $i++) {
            $webposIndex->getCheckoutCartHeader()->getMultiOrderItem($i)->click();
            $webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
            for ($p=1; $p<=3; $p++) {
                $webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
                $webposIndex->getMsWebpos()->waitCheckoutLoader();
            }
            for ($j=$k;$j<2*$i; $j++) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $webposIndex->getCheckoutCartItems()->getCartItem($products[$j]->getName())->isVisible(),
                    'On the AssertWebposAddProductTo2CartsCP20 TaxClass - The cart item with name\'s'.$products[$j]->getName().' was not visible.'
                );
            }
            $k += $j;
            sleep(5);
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "On the checkout Page, All The product items just added to two Carts were visible successfully.";
    }
}