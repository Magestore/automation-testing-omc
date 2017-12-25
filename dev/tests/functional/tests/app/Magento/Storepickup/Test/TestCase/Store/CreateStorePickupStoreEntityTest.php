<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 5:46 PM
 */

namespace Magento\Storepickup\Test\TestCase\Store;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Fixture\StorepickupStore;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;
use Magento\Storepickup\Test\Page\Adminhtml\StoreNew;

/**
 * Steps:
 * 1. Login to the backend.
 * 2. Navigate to Store Pickup > Manage Store.
 * 3. Start to Add New Store .
 * 4. Fill in data according to data set.
 * 5. Save Store.
 * 6. Perform appropriate assertions.
 *
 */
class CreateStorePickupStoreEntityTest extends Injectable
{
    /**
     * @var StoreIndex
     */
    protected $storeIndex;

    /**
     * @var StoreNew
     */
    protected $storeNew;

    public function __inject(StoreIndex $storeIndex, StoreNew $storeNew)
    {
        $this->storeIndex = $storeIndex;
        $this->storeNew = $storeNew;
    }

    public function test(StorepickupStore $storepickupStore)
    {
        $this->storeIndex->open();
        $this->storeIndex->getStoreGridPageActions()->clickActionButton('add');
        $this->storeNew->getStoreForm()->fill($storepickupStore);
        $this->storeNew->getStoreFormPageActions()->save();
        return ['storepickupStore' => $storepickupStore];
    }
}