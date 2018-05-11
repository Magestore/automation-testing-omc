<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 09:10
 */

namespace Magento\Webpos\Test\TestCase\Staff\MassAction;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 * Class ManageStaffMS17MS19Test
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps:
 * 1. Tick on checkbox to select 1 Staff on the grid whose status is disable
 * 2. Click on Mass action > Change status
 * 3. Select [Enable] option
 *
 * Acceptance:
 * 2. Show 2 options: Enable and Disable
 * 3.
 * - The status of the selected staff will be changed to Enable
 * - Show message "A total of 1 record(s) were updated."
 *
 * @package Magento\Webpos\Test\TestCase\Staff\MassAction
 */
class ManageStaffMS17MS19Test extends Injectable
{
    /**
     * Staff Index Page
     * @var StaffIndex
     */
    protected $staffIndex;

    public function __inject(
        StaffIndex $staffIndex
    )
    {
        $this->staffIndex = $staffIndex;
    }

    public function test(Staff $staff, $status)
    {
        $staff->persist();
        $staffs = [$staff];
        $massActionStaffs = [];
        $massActionStaffs[] = ['username' => $staff->getUsername()];
        $this->staffIndex->open();
        $this->staffIndex->getStaffsGrid()->massaction($massActionStaffs, ['Change status' => $status], false, '');
        return ['staffs' => $staffs];
    }
}