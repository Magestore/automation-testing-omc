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

/**
 * Test Flow:
 * Preconditions:
 * 1. Create 2 credit stores enable or disable
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  Store Credit > Manage Store
 * 3. Select 2 stores from preconditions
 * 4. Select in dropdown choose action
 * 5. Accept alert
 * 6. Perform all assertions according to dataset
 *
 */
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
        $storeIndex->open();
        $storeIndex->getStoreGrid()->massaction([], 'Delete', true, 'Select All');
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