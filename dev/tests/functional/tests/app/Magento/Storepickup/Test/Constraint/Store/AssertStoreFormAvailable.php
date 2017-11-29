<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 1:18 PM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreNew;

/**
 * Class AssertStoreFormAvailable
 * @package Magento\Storepickup\Test\Constraint\Store
 */
class AssertStoreFormAvailable extends AbstractConstraint
{

    /**
     * @param StoreNew $storeNew
     */
    public function processAssert(StoreNew $storeNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->isVisible(),
            'Store form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->generalTitleIsVisible(),
            'General title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->storeNameFieldIsVisible(),
            'Store name field is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Store form is available.';
    }
}