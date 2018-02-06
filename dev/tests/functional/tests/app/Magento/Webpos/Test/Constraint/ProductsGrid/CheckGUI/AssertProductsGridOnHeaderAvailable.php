<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/5/2018
 * Time: 1:43 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductsGridOnHeaderAvailable
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI
 */
class AssertProductsGridOnHeaderAvailable extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->getSearchInput()->isVisible(),
            'Products Grid - Search Input is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->getCategoryButton()->isVisible(),
            'Products Grid - Category Button is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Products Grid - On Header is available.';
    }
}