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

class StoreGridSortingTest extends GridSortingTest
{
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $store = $fixtureFactory->createByCode('storepickupStore', ['dataset' => 'store2']);
        $store->persist();
    }
}