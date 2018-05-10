<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 08/05/2018
 * Time: 15:55
 */

namespace Magento\Webpos\Test\TestCase\Staff\MassAction;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 * Class ManageStaffMS15Test
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps:
 * "1. Tick on checkbox to select 1 Staff on the grid
 * 2. Click on Mass action > Delete
 * 3. Click on [OK] button"
 *
 * Acceptance:
 * "3.
 * - Close the confirmation popup
 * - Delete the selected staff successfully and show message: ""A total of 1 record(s) were deleted."""
 *
 * @package Magento\Webpos\Test\TestCase\Staff\MassAction
 */
class ManageStaffMS15Test extends Injectable
{
    /**
     * Staff Index Page
     * @var StaffIndex
     */
    protected $staffIndex;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(
        StaffIndex $staffIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->staffIndex = $staffIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function test(Staff $staff)
    {
        $staff->persist();
        $this->staffIndex->open();
        $this->staffIndex->getStaffsGrid()->waitLoader();
        $this->staffIndex->getStaffsGrid()->getFilterButton()->click();
        $this->staffIndex->getStaffsGrid()->resetFilter();
        $this->staffIndex->getStaffsGrid()->searchAndSelect([
            'username' => $staff->getUsername()
        ]);
        $this->staffIndex->getStaffsGrid()->selectAction('Delete');
        $this->staffIndex->getModal()->waitForLoader();
        $this->staffIndex->getModal()->getOkButton()->click();
        $this->staffIndex->getStaffsGrid()->waitLoader();
        \PHPUnit_Framework_Assert::assertFalse(
            $this->staffIndex->getModal()->getModalPopup()->isVisible(),
            'Modal is not closed'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            "A total of 1 record(s) were deleted.",
            $this->staffIndex->getMessagesBlock()->getSuccessMessage(),
            'Message success not correct'
        );
    }
}