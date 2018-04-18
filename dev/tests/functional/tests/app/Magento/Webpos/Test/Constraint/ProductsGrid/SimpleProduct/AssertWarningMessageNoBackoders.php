<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/9/2018
 * Time: 2:26 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertWarningMessageNoBackoders
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct
 */
class AssertWarningMessageNoBackoders extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $products
     */
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        $productName = $products[0]['product']->getName();
        $productQtyOnPage = $webposIndex->getCheckoutProductList()->getFirstProductQty()->getText();
        $productQtyOnPage = (int) str_replace(' item(s)','', $productQtyOnPage);
        \PHPUnit_Framework_Assert::assertEquals(
            'We don\'t have as many "'. $productName .'" as you requested. The current in-stock qty is "'. $productQtyOnPage .'"',
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            "Warning message's Content is Wrong"
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Message is correctly.';
    }
}