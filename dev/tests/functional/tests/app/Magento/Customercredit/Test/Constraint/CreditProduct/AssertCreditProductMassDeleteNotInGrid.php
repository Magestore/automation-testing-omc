<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/20/2017
 * Time: 1:36 PM
 */

namespace Magento\Customercredit\Test\Constraint\CreditProduct;

use Magento\Customercredit\Test\Fixture\CreditProduct;
use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCreditProductMassDeleteNotInGrid extends AbstractConstraint
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
        for ($i = 0; $i < $productQtyToDelete; $i++) {
            \PHPUnit_Framework_Assert::assertFalse(
                $creditProductIndex->getCreditProductGrid()->isRowVisible(['name' => $products[$i]->getName()]),
                'Credit Product with name ' . $products[$i]->getName() . 'is present in Credit Product grid.'
            );
        }
    }

    /**
     * Success message if product not in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Deleted Credit Products are absent in Credit Product grid.';
    }
}