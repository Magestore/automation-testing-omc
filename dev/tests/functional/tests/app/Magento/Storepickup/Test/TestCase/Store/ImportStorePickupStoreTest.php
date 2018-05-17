<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/21/2017
 * Time: 4:02 PM
 */

namespace Magento\Storepickup\Test\TestCase\Store;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\StoreImportStore;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

/**
 * Steps:
 * 1. LoginTest to the backend.
 * 2. Navigate to Store Pickup > Manage Store.
 * 3. Start to Import Store.
 * 4. Fill in data according to data set.
 * 5. Import Stores.
 * 6. Perform appropriate assertions.
 *
 */
class ImportStorePickupStoreTest extends Injectable
{
    /**
     * @var StoreIndex
     */
    protected $storeIndex;

    /**
     * @var StoreImportStore
     */
    protected $storeImportStore;

    /**
     * @param StoreIndex $storeIndex
     * @param StoreImportStore $storeImportStore
     */
    public function __inject(
        StoreIndex $storeIndex,
        StoreImportStore $storeImportStore
    ){
        $this->storeIndex = $storeIndex;
        $this->storeImportStore = $storeImportStore;
        $storeIndex->open();
        $storeIndex->getStoreGrid()->massaction([], 'Delete', true, 'Select All');
    }

    public function test()
    {
        $csvFile = 'storepickup.csv';
        $this->storeIndex->open();
        $this->storeIndex->getStoreGridPageActions()->clickActionButton('importstore');
        $this->storeImportStore->getStoreImportStoreForm()->downloadSample($csvFile);
        \PHPUnit_Framework_Assert::assertFileExists($csvFile);
        $this->storeImportStore->getStoreImportStoreForm()->fillCsvFormFile($csvFile);
        $this->storeImportStore->getStoreImportStorePageActions()->save();
        unlink($csvFile);
    }
}