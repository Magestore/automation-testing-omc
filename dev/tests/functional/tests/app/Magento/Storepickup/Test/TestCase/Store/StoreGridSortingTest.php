<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 4:50 PM
 */

namespace Magento\Storepickup\Test\TestCase\Store;

use Magento\Ui\Test\TestCase\GridSortingTest;
use Magento\Mtf\Fixture\FixtureFactory;

/**
 * Precondition:
 * 1. Create items
 *
 * Steps:
 * 1. Navigate to backend.
 * 2. Go to grid page Store Pickup > Manage Store.
 * 3. Sort grid using provided columns
 * 5. Perform Asserts
 *
 */
class StoreGridSortingTest extends GridSortingTest
{
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $store = $fixtureFactory->createByCode('storepickupStore', ['dataset' => 'store2']);
        $store->persist();
    }
}