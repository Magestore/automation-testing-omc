<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/11/2017
 * Time: 1:37 PM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreNew;

class AssertStoreFormRequireFieldVisible extends AbstractConstraint
{

    public function processAssert(StoreNew $storeNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->addressRequireErrorIsVisible(),
            'Address field require error is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->cityRequireErrorIsVisible(),
            'City field require error is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->zipcodeRequireErrorIsVisible(),
            'Zipcode field require error is not visible.'
        );
        $storeNew->getStoreForm()->openTab('general-information');
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->storeNameRequireErrorIsVisible(),
            'Store name field require error is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'All require fields are visible.';
    }
}