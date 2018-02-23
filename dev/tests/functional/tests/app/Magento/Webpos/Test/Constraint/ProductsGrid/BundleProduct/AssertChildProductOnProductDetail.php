<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/22/2018
 * Time: 10:38 AM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\BundleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertChildProductOnProductDetail
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\BundleProduct
 */
class AssertChildProductOnProductDetail extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $products
     * @param null $checkDefault
     */
    public function processAssert(WebposIndex $webposIndex, $products, $checkDefault = null)
    {
        $product = $products[0]['product'];
        $expectedPrice = 0;
        $bundleOptionProducts = $product->getData()['bundle_selections']['products'];
        foreach ($bundleOptionProducts as $option => $bundleOptions) {

            // Get first option, which is default
            $firstItemProduct = $bundleOptions[0];

            // Check product price of option
            \PHPUnit_Framework_Assert::assertEquals(
                $firstItemProduct->getPrice(),
                (float) substr($webposIndex->getCheckoutProductDetail()->getProductPriceOfOption($firstItemProduct->getName())->getText(), 2),
                'Price of product ' . $firstItemProduct->getName() .' not correctly.'
            );

            // Check auto select first radio button
            \PHPUnit_Framework_Assert::assertTrue(
                (boolean) $webposIndex->getCheckoutProductDetail()->getRadioItemOfBundleProduct($firstItemProduct->getName())->getAttribute('checked'),
                'Auto checked product of option' . ($option + 1) .' not correctly.'
            );

            // Check qty of option
            $qtyOfOption = (int) $webposIndex->getCheckoutProductDetail()->getQtyOfOption($option + 1)->getValue();
            if (isset($checkDefault)){
                \PHPUnit_Framework_Assert::assertEquals(
                    1,
                    $qtyOfOption,
                    'Qty of option' . ($option + 1) .' not correctly.'
                );
            }
            $expectedPrice = $expectedPrice + ($firstItemProduct->getPrice() * $qtyOfOption);
        }
        $actualPrice = $webposIndex->getCheckoutProductDetail()->getBundleProductPrice()->getText();
        $actualPrice = str_replace(',','', $actualPrice);
        $actualPrice = (float) substr($actualPrice, 1);

        // Check SUM price
        \PHPUnit_Framework_Assert::assertEquals(
            $expectedPrice,
            $actualPrice,
            'Price not correctly.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Bundle Product Detail is correctly.';
    }
}