<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/5/2017
 * Time: 3:32 PM
 */

namespace Magento\Customercredit\Test\Constraint\CreditProduct;

use Magento\Customercredit\Test\Fixture\CreditProduct;
use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCreditProductInGrid extends AbstractConstraint
{
    /**
     * Fields used to filter rows in the grid.
     * @var array
     */
    protected $fieldsToFilter = ['name', 'sku'];

    public function processAssert(CreditProduct $product, CreditProductIndex $creditProductIndex)
    {
        $data = $product->getData();
        $filter = [];
        foreach ($this->fieldsToFilter as $field) {
            $filter[$field] = $data[$field];
        }
        $creditProductIndex->open();
        $errorMessage = implode(', ', $filter);
        \PHPUnit_Framework_Assert::assertTrue(
            $creditProductIndex->getCreditProductGrid()->isRowVisible($filter),
            'Credit Product with following data: \'' . $errorMessage . '\' '
            . 'is absent in Credit Product grid.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Credit Product is present in Credit Product grid.';
    }
}