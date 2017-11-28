<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 8:41 AM
 */

namespace Magento\Storepickup\Test\Constraint;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

class AssertDataGridToolbarAvailable extends AbstractConstraint
{

    public function processAssert(StoreIndex $storeIndex)
    {
        $storeIndex->getStoreGrid()->waitingForGridVisible();
        \PHPUnit_Framework_Assert::assertTrue(
            $storeIndex->getStoreGrid()->dataGridSearchIsVisible(),
            'Data grid search is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeIndex->getStoreGrid()->actionButtonIsVisible(),
            'Action button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeIndex->getStoreGrid()->filtersButtonIsVisible(),
            'Filters button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeIndex->getStoreGrid()->dataGridActionIsVisible(),
            'Data grid action is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeIndex->getStoreGrid()->dataGridPagerIsVisible(),
            'Data grid pager is not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Data grid toolbar is available.';
    }
}