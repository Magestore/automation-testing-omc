<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Location;

/**
 * Check that success message is displayed after widget saved
 */
class AssertCheckInfoDisplayOnGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param LocationIndex $locationIndex
     * @return void
     */
    public function processAssert(LocationIndex $locationIndex, Location $location)
    {
        $locationIndex->getLocationsGrid()->search(['display_name' => $location->getDisplayName()]);
        $id = $locationIndex->getLocationsGrid()->getAllIds()[0];

        \PHPUnit_Framework_Assert::assertEquals(
            $location->getDescription(),
            $locationIndex->getLocationsGrid()->getColumnValue($id, 'Description'),
            'DisplayName is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $location->getAddress(),
            $locationIndex->getLocationsGrid()->getColumnValue($id, 'Address'),
            'Address is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $location->getDisplayName(),
            $locationIndex->getLocationsGrid()->getColumnValue($id, 'Location Name'),
            'Location Name is incorrect'
        );
        $locationIndex->getLocationsGrid()->resetFilter();
    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Info staff is incorrect on grid';
    }
}
