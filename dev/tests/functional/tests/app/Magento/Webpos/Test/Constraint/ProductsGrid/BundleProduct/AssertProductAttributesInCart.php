<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/22/2018
 * Time: 4:02 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\BundleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductAttributesInCart
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\BundleProduct
 */
class AssertProductAttributesInCart extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartItems()->getFirstCartItemOption()->isVisible(),
            'Product Attributes is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product Attributes is visible.';
    }
}