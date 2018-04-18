<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/11/2017
 * Time: 2:01 PM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupStore;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

class AssertStoreInGrid extends AbstractConstraint
{
    /**
     * Filters array mapping.
     *
     * @var array
     */
    private $filter;

    public function processAssert(
        StorepickupStore $storepickupStore,
        StoreIndex $storeIndex
    ) {
        $storeIndex->open();
        $data = $storepickupStore->getData();
        $this->filter = ['name' => $data['store_name']];
        $storeIndex->getStoreGrid()->search($this->filter);

        \PHPUnit_Framework_Assert::assertTrue(
            $storeIndex->getStoreGrid()->isRowVisible($this->filter, false, false),
            'Store is absent in Store grid'
        );

//        \PHPUnit_Framework_Assert::assertEquals(
//            count($storeIndex->getStoreGrid()->getAllIds()),
//            1,
//            'There is more than one store founded'
//        );
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