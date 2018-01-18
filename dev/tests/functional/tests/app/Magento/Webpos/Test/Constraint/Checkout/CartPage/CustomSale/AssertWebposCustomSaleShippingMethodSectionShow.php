<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 1/12/2018
 * Time: 8:33 AM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertWebposCustomSaleShippingMethodSectionShow extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutShippingMethod()->isVisible(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Shippable = On.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "TaxClass page is default";
    }
}