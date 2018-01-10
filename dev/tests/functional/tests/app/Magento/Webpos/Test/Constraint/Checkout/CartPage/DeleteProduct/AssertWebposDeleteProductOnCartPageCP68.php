<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/10/2018
 * Time: 4:33 PM
 */
namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\DeleteProduct;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertWebposDeleteProductOnCartPageCP68 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertNotTrue(
            $webposIndex->getCheckoutCartItems()->getFirstCartItem()->isVisible(),
            'Cart is empty'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "CategoryRepository - TaxClass Page - Check Cart empty";
    }
}