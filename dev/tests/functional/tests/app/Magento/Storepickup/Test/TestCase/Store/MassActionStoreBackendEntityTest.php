<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 10:19 AM
 */

namespace Magento\Storepickup\Test\TestCase\Store;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;
use Magento\Storepickup\Test\Page\Adminhtml\StoreNew;

class MassActionStoreBackendEntityTest extends Injectable
{
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var StoreIndex
     */
    protected  $storeIndex;

    /**
     * @var StoreNew
     */
    protected $storeNew;

    /**
     * @param FixtureFactory $fixtureFactory
     * @param StoreIndex $storeIndex
     * @param StoreNew $storeNew
     */
    public function __inject(
        FixtureFactory $fixtureFactory,
        StoreIndex $storeIndex,
        StoreNew $storeNew
    ){
        $this->fixtureFactory = $fixtureFactory;
        $this->storeIndex = $storeIndex;
        $this->storeNew = $storeNew;
    }

    public function test($storesQty, $storeDataSet, $storeMassAction, $acceptAlert = false)
    {
        $stores = $this->createStores($storesQty, $storeDataSet);
        $massActionStores = [];
        foreach ($stores as $store) {
            $massActionStores[] = ['name' => $store->getStoreName()];
        }
        $this->storeIndex->open();
        $this->storeIndex->getStoreGrid()->massaction($massActionStores, $storeMassAction, $acceptAlert);

        return ['stores' => $stores];
    }

    public function createStores($storesQty, $storeDataSet)
    {
        $stores = [];
        for ($i = 0; $i < $storesQty; $i++) {
            $store = $this->fixtureFactory->createByCode('storepickupStore', ['dataset' => $storeDataSet]);
            $store->persist();
            $stores[] = $store;
        }
        return $stores;
    }
}