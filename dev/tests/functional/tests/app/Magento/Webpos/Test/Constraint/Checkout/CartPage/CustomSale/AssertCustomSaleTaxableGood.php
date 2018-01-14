<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 1/12/2018
 * Time: 9:07 AM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertCustomSaleTaxableGood
 * @package Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale
 */

class AssertCustomSaleTaxableGood extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $taxRate)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            (float) $taxRate,
            (float) $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice("Tax")->getText(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Tax None'
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