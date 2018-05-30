<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 08:50
 */

namespace Magento\Webpos\Test\TestCase\Staff\MassAction;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\Staff\GUI\AssertGridNoRecord;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 * Class ManageStaffMS16Test
 * @package Magento\Webpos\Test\TestCase\Staff\MassAction
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps:
 * "1. Tick on some checkboxs to select more than 1 Staff on the grid
 * 2. Click on Mass action > Delete
 * 3. Click on [OK] button"
 *
 * Acceptance:
 * 3.
 * - Close the confirmation popup
 * - Delete the selected staffs successfully and show message: "A total of 1 record(s) were deleted."
 */
class ManageStaffMS16Test extends Injectable
{
    /**
     * Staff Index Page
     * @var StaffIndex
     */
    protected $staffIndex;

    /**
     * AssertGridNoRecord.
     *
     * @var AssertGridNoRecord
     */
    protected $assertGridNoRecord;

    public function __inject(
        StaffIndex $staffIndex,
        AssertGridNoRecord $assertGridNoRecord
    )
    {
        $this->staffIndex = $staffIndex;
        $this->assertGridNoRecord = $assertGridNoRecord;
    }

    public function test(Staff $staff1, Staff $staff2)
    {
        $staff1->persist();
        $staff2->persist();
        $this->staffIndex->open();
        $this->staffIndex->getStaffsGrid()->waitLoader();
        $this->staffIndex->getStaffsGrid()->getFilterButton()->click();
        $this->staffIndex->getStaffsGrid()->resetFilter();
        $this->staffIndex->getStaffsGrid()->selectItems([
            [
                'username' => $staff1->getUsername()
            ],
            [
                'username' => $staff2->getUsername()
            ]
        ]);
        $this->staffIndex->getStaffsGrid()->selectAction('Delete');
        $this->staffIndex->getModal()->waitForLoader();
        $this->staffIndex->getModal()->getOkButton()->click();
        $this->staffIndex->getStaffsGrid()->waitLoader();

        // Check Staff 1
        $this->staffIndex->getStaffsGrid()->search(['username' => $staff1->getUsername()]);
        $this->staffIndex->getStaffsGrid()->waitLoader();
        $this->assertGridNoRecord->processAssert($this->staffIndex);

        // Check Staff 2
        $this->staffIndex->getStaffsGrid()->search(['username' => $staff2->getUsername()]);
        $this->staffIndex->getStaffsGrid()->waitLoader();
        $this->assertGridNoRecord->processAssert($this->staffIndex);
    }
}