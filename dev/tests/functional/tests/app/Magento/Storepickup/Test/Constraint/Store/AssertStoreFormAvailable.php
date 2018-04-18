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
            'General Information title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->contactTitleIsVisible(),
            'Contact Information title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->ownerInformationTitleIsVisible(),
            'Owner Information title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->metaInformationTitleIsVisible(),
            'Meta Information title is not visible.'
        );
        $generalInformationFields = $storeNew->getStoreForm()->getGeneralInformationFields();
        foreach ($generalInformationFields as $fieldName => $selector) {
            \PHPUnit_Framework_Assert::assertTrue(
                $storeNew->getStoreForm()->fieldIsVisible($selector),
                $fieldName . ' field is not visible.'
            );
        }
        $storeNew->getStoreForm()->openTab('google-map');
        $googleMapFields = $storeNew->getStoreForm()->getGoogleMapFields();
        foreach ($googleMapFields as $fieldName => $selector) {
            \PHPUnit_Framework_Assert::assertTrue(
                $storeNew->getStoreForm()->fieldIsVisible($selector),
                $fieldName . ' field is not visible.'
            );
        }
        $storeNew->getStoreForm()->openTab('image-gallery');
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->imageGaleryFieldIsVisible(),
            'Image Galery field is not visible.'
        );
        $storeNew->getStoreForm()->openTab('store-schedule');
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->scheduleFieldIsVisible(),
            'Schedule field is not visible.'
        );
        $storeNew->getStoreForm()->openTab('store-tags');
        sleep(1);
        $storeNew->getStoreForm()->waitOpenTagTab();
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->fieldIsVisible('[id="storepickupadmin_tag_grid"]'),
            'Store Tag grid is not visible.'
        );
        $storeNew->getStoreForm()->openTab('store-holidays');
        $storeNew->getStoreForm()->waitOpenHolidayTab();
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->fieldIsVisible('[id="storepickupadmin_holiday_grid"]'),
            'Store Holiday grid is not visible.'
        );
        $storeNew->getStoreForm()->openTab('store-orders');
        $storeNew->getStoreForm()->waitOpenOrderTab();
        \PHPUnit_Framework_Assert::assertTrue(
            $storeNew->getStoreForm()->fieldIsVisible('[id="storepickupadmin_orders_grid"]'),
            'Store Holiday grid is not visible.'
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