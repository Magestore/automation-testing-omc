<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 1:09 PM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

class AssertStoreMassEnableInGrid extends AbstractConstraint
{
    public function processAssert(
        array $stores,
        StoreIndex $storeIndex
    ) {
        $storeIndex->open();
        foreach ($stores as $store) {
            $data = $store->getData();
            $filter = [
                'name' => $data['store_name'],
                'status' => 'Enabled'
            ];
            $storeIndex->getStoreGrid()->search($filter);
            \PHPUnit_Framework_Assert::assertTrue(
                $storeIndex->getStoreGrid()->isRowVisible($filter, false, false),
                'Store is absent in Store grid'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                count($storeIndex->getStoreGrid()->getAllIds()),
                1,
                'There is more than one store founded'
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
        return 'Store is present in grid.';
    }
}