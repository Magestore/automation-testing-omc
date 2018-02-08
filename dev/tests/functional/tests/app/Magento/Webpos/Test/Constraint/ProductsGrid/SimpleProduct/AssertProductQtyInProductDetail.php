<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/8/2018
 * Time: 2:33 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductQtyInProductDetail
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct
 */
class AssertProductQtyInProductDetail extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     * @param $qty
     */
    public function processAssert(WebposIndex $webposIndex, $qty)
    {
        $productQtyOnPage = (float) $webposIndex->getCheckoutProductDetail()->getProductQty()->getValue();
        \PHPUnit_Framework_Assert::assertEquals(
            $qty,
            $productQtyOnPage,
            'Product qty is not correctly.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product qty was correctly.';
    }
}