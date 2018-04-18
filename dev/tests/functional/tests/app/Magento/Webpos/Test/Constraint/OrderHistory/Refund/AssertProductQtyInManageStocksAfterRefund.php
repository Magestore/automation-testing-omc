<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/1/2018
 * Time: 10:02 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductQtyInManageStocksAfterRefund extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $webposIndex->getCMenu()->manageStocks();
        sleep(1);
        foreach ($products as $item) {
            if (isset($item['returnToStock'])) {
                $expectedQty = $item['product']->getQuantityAndStockStatus()['qty'];
            } else {
                $expectedQty = $item['product']->getQuantityAndStockStatus()['qty'] - $item['orderQty'];
            }
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

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product qtys are correct.';
    }
}