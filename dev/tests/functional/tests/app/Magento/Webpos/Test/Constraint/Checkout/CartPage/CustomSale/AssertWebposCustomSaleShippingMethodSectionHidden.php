<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 4:30 PM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertWebposCustomSaleShippingMethodSectionHidden extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertNotTrue(
            $webposIndex->getCheckoutShippingMethod()->isVisible(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Shippable = Off.'
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