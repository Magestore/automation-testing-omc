<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/02/2018
 * Time: 19:20
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Form;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that success message is displayed after widget saved
 */
class AssertLocationContinueEditAfterCreateStaff extends AbstractConstraint
{
    /**
     *
     * @param LocationNews
     * @return void
     */
    public function processAssert(LocationNews $locationNews, $fields)
    {
       //Display name, Address, Description
        \PHPUnit_Framework_Assert::assertEquals(
            $fields['page_display_name'],
            $locationNews->getLocationsForm()->getLocationName(),
            'Location name is incorrect '
        );
       \PHPUnit_Framework_Assert::assertEquals(
           $fields['page_address'],
           $locationNews->getLocationsForm()->getAddress(),
            'Address is incorrect '
        );
       \PHPUnit_Framework_Assert::assertEquals(
           $fields['page_description'],
           $locationNews->getLocationsForm()->getDescription(),
            'Description is incorrect '
        );

        //Warehouse
        \PHPUnit_Framework_Assert::assertEquals(
            $fields['page_warehouse_id'],
            $locationNews->getLocationsForm()->getWarehouse(),
            'Warehouse is incorrect '
        );

        //Store view
        \PHPUnit_Framework_Assert::assertEquals(
            $fields['page_store_id'],
            trim($locationNews->getLocationsForm()->getStoreView()),
            'Warehouse is incorrect '
        );
    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Fields are correct';
    }
}
