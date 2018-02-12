<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/9/2018
 * Time: 2:14 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductQtyInProductList
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct
 */
class AssertProductQtyInProductList extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $qty
     */
    public function processAssert(WebposIndex $webposIndex, $qty)
    {
        $productQtyOnPage = $webposIndex->getCheckoutProductList()->getFirstProductQty()->getText();
        $productQtyOnPage = (int) str_replace(' item(s)','', $productQtyOnPage);
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