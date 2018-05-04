<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/3/18
 * Time: 5:16 PM
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductUpdateSuccess extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $product, $productInfo)
    {
        if (isset($productInfo['qty'])) {
            \PHPUnit_Framework_Assert::assertEquals(
                $productInfo['qty'],
                $webposIndex->getManageStockList()->getProductQtyValue($product->getName()),
                'Quantity of product is incorrect'
            );
        }

        if (isset($productInfo['inStock'])) {
            if ((int)$productInfo['qty'] <= 0) {
                \PHPUnit_Framework_Assert::assertFalse(
                    $webposIndex->getManageStockList()->getInStockValueByProduct($product->getName()),
                    'inStock of product is incorrect'
                );
            } else {
                \PHPUnit_Framework_Assert::assertTrue(
                    $webposIndex->getManageStockList()->getInStockValueByProduct($product->getName()),
                    'inStock of product is incorrect'
                );
            }

        }

        if (isset($productInfo['manageStock'])) {
            if ($productInfo['manageStock']) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $webposIndex->getManageStockList()->getManageStockValueByProduct($product->getName()),
                    'Manage Stock of product is incorrect'
                );
            } else {
                \PHPUnit_Framework_Assert::assertFalse(
                    $webposIndex->getManageStockList()->getManageStockValueByProduct($product->getName()),
                    'Manage Stock of product is incorrect'
                );
            }

        }

        if (isset($productInfo['backOrders'])) {
            if ($productInfo['backOrders']) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $webposIndex->getManageStockList()->getBackOrdersValueByProduct($product->getName()),
                    'Manage Stock of product is incorrect'
                );
            } else {
                \PHPUnit_Framework_Assert::assertFalse(
                    $webposIndex->getManageStockList()->getBackOrdersValueByProduct($product->getName()),
                    'Manage Stock of product is incorrect'
                );
            }

        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Manage Stock - Product is updated';
    }

}