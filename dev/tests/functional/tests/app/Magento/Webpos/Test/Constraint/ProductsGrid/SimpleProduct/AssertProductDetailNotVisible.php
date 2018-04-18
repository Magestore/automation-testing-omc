<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/8/2018
 * Time: 3:42 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductDetailNotVisible
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct
 */
class AssertProductDetailNotVisible extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        if($webposIndex->getCheckoutProductDetail()->isVisible()){
            $webposIndex->getCheckoutProductDetail()->getButtonCancel()->click();
            sleep(1);
        }
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getCheckoutProductDetail()->isVisible(),
            'Product Detail Popup is not closed.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product Detail was closed.';
    }
}