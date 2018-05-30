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
 * Class ManageStaffMS18MS20Test
 * @package Magento\Webpos\Test\TestCase\Staff\MassAction
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps:
 * "1. Tick on some checkboxs to select some Staffs on the grid whose status are disable
 * 2. Click on Mass action > Change status
 * 3. Select [Enable] option"
 *
 * Acceptance:
 * "3.
 * - The status of the selected staffs will be changed to Enable
 * - Show message ""A total of 1 record(s) were updated."""
 *
 */
class ManageStaffMS18MS20Test extends Injectable
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

    public function test(Staff $staff1, Staff $staff2, $status)
    {
        $staff1->persist();
        $staff2->persist();
        $staffs = [$staff1, $staff2];
        $massActionStaffs = [
            ['username' => $staff1->getUsername()],
            ['username' => $staff2->getUsername()]
        ];
        $this->staffIndex->open();
        $this->staffIndex->getStaffsGrid()->massaction($massActionStaffs, ['Change status' => $status], false, '');
        return ['staffs' => $staffs];
    }
}