<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/23/2018
 * Time: 9:19 AM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductBlockNoRecord
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI
 */
class AssertProductBlockNoRecord extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->getSpanNoRecord()->isVisible(),
            'Products Grid - Span no record is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Products Grid - Span "We couldn\'t find any records." is visible.';
    }
}