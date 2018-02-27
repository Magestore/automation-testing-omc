<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/23/2018
 * Time: 2:33 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\ConnectToManageStock;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductQtyAfterCreateOrder extends AbstractConstraint
{

    public function processAssert(WebposIndex $webposIndex, $products)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $webposIndex->getCMenu()->manageStocks();
        sleep(1);
        foreach ($products as $item) {
            $expectedQty = $item['product']->getQuantityAndStockStatus()['qty'] - $item['orderQty'];
            $productName = $item['product']->getName();
            $webposIndex->getManageStockList()->searchProduct($productName);
            $actualProductQty = $webposIndex->getManageStockList()->getProductQtyValue($productName);
            \PHPUnit_Framework_Assert::assertEquals(
                $expectedQty,
                $actualProductQty,
                'Product qty is not equal actual product qty in manage stocks.'
                . "\nExpected: " . $expectedQty
                . "\nActual: " . $actualProductQty
            );
        }
        sleep(2);
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Qty of all products have been subtracted correctly';
    }
}