<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/20/2017
 * Time: 1:41 PM
 */

namespace Magento\Customercredit\Test\Constraint\CreditProduct;

use Magento\Customercredit\Test\Fixture\CreditProduct;
use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCreditProductMassDeleteInGrid extends AbstractConstraint
{
    /**
     *
     * @param CreditProductIndex $creditProductIndex
     * @param int $productQtyToDelete
     * @param CreditProduct[] $products
     * @return void
     */
    public function processAssert(
        CreditProductIndex $creditProductIndex,
        $productQtyToDelete,
        $products
    ) {
        $products = array_slice($products, $productQtyToDelete);
        foreach ($products as $product) {
            \PHPUnit_Framework_Assert::assertTrue(
                $creditProductIndex->getCreditProductGrid()->isRowVisible(['name' => $product->getName()]),
                'Product with name ' . $product->getName() . 'is absent in Product grid.'
            );
        }
    }

    /**
     * Success message if Credit Product in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Credit Product are present in Credit Product grid.';
    }
}