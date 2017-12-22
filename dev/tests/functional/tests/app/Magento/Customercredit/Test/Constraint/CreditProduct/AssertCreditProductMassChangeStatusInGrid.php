<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/20/2017
 * Time: 2:29 PM
 */

namespace Magento\Customercredit\Test\Constraint\CreditProduct;

use Magento\Customercredit\Test\Fixture\CreditProduct;
use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCreditProductMassChangeStatusInGrid extends AbstractConstraint
{
    /**
     * @param CreditProduct[] $products
     * @param CreditProductIndex $creditProductIndex
     * @param string $status
     */
    public function processAssert(
        $products,
        CreditProductIndex $creditProductIndex,
        $status
    ) {
        $creditProductIndex->open();
        foreach ($products as $product) {
            $filter = [
                'name' => $product->getName(),
                'status' => $status
            ];
            $creditProductIndex->getCreditProductGrid()->search($filter);
            \PHPUnit_Framework_Assert::assertTrue(
                $creditProductIndex->getCreditProductGrid()->isRowVisible($filter, false, false),
                'Product is absent in Product grid'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                count($creditProductIndex->getCreditProductGrid()->getAllIds()),
                1,
                'There is more than one product founded'
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
        return 'Products is present in grid.';
    }
}