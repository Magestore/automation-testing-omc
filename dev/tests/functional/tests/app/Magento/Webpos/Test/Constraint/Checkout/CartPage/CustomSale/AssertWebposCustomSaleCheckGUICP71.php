<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 10:16 AM
 */
namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertWebposCustomSaleCheckGUICP71
 * @package Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale
 */
class AssertWebposCustomSaleCheckGUICP71 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCustomSale()->getProductNameInput()->isVisible(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Input Product name is not show.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCustomSale()->getDescriptionInput()->isVisible(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Input Product Description is not show.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCustomSale()->getProductPriceInput()->isVisible(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Input Product price is not show.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCustomSale()->getShipAbleCheckbox()->isVisible(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Input ShipAble is not show.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCustomSale()->getCancelButton()->isVisible(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Button cannel is not show.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCustomSale()->getAddToCartButton()->isVisible(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Add to cart is not show.'
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