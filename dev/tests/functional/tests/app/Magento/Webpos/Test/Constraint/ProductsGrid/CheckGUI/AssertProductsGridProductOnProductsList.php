<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/5/2018
 * Time: 3:46 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductsGridProductOnProductsList extends AbstractConstraint
{

    public function processAssert(WebposIndex $webposIndex, $products)
    {
        $productImage = $products[0]['product']->getImage();
        $productName = $products[0]['product']->getName();
        $productImageOnPage = $webposIndex->getCheckoutProductList()->getFirstProductImage()->getAttribute('src');
        $productNameOnPage = $webposIndex->getCheckoutProductList()->getFirstProductName()->getText();

        \PHPUnit_Framework_Assert::assertEquals(
            $productName,
            $productNameOnPage,
            'Products Grid - Product Name is not correctly.'
        );

        $productQty = $products[0]['product']->getQuantityAndStockStatus();
        $productQty = $productQty["qty"];
        if ($productQty > 0){
            $productQtyOnPage = $webposIndex->getCheckoutProductList()->getFirstProductQty()->getText();
            $productQtyOnPage = (int) str_replace(' item(s)','', $productQtyOnPage);
            \PHPUnit_Framework_Assert::assertEquals(
                $productQty,
                $productQtyOnPage,
                'Products Grid - Product Qty is not correctly.'
            );
        }elseif ($productQty == 0){
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getToaster()->getWarningMessage()->isVisible(),
                'Success Message is not displayed'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                'This product is currently out of stock',
                $webposIndex->getToaster()->getWarningMessage()->getText(),
                'Notification Content is wrong'
            );
        }
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Products Grid - Product Information is correctly.';
    }
}