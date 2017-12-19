<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 1:37 PM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

class AssertStoreMassDeleteNotInGrid extends AbstractConstraint
{
    public function processAssert(
        array $stores,
        StoreIndex $storeIndex
    ){
        $storeIndex->open();
        foreach ($stores as $store) {
            \PHPUnit_Framework_Assert::assertFalse(
                $storeIndex->getStoreGrid()->isRowVisible(['name' => $store->getStoreName()]),
                'Store with name ' . $store->getStoreName() . 'is present in Store grid.'
            );
        }
    }

    public function toString()
    {
        return 'Store is absent in Store grid.';
    }
}