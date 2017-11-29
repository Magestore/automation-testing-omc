<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 1:55 PM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreImportStore;

class AssertStoreImportStoreFormAvailable extends AbstractConstraint
{

    public function processAssert(StoreImportStore $storeImportStore)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $storeImportStore->getStoreImportStoreForm()->isVisible(),
            'Import store form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeImportStore->getStoreImportStoreForm()->importStoreTitleIsVisible(),
            'Import store title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeImportStore->getStoreImportStoreForm()->importFileFieldIsVisible(),
            'Import store file field is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Import store form is available.';
    }
}