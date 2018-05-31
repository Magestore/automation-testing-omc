<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 17/02/2018
 * Time: 19:27
 */

namespace Magento\Webpos\Test\TestCase\Staff\AddStaff;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Webpos\Test\Fixture\Staff;

/**
 * Add Staff
 * Testcase MS28 - Check [Save and continue] button without filling out all fields
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps
 * 1. Click on [Add Staff] button
 * 2. Fill out correctly all fields
 * 3. Click on [Save] button
 *
 * Acceptance Criteria
 * 3.
 * - Create staff successfully
 * - Display Edit staff page to continue edit, the inputed fields are still shown exactly except 2 fields [Password] and [Password Confirmation] are blank
 * - Show message: "Staff was successfully saved"
 *
 * Class WebposManageStaffMS28Test
 * @package Magento\Webpos\Test\TestCase\Staff\AddStaff
 */
class WebposManageStaffMS28Test extends Injectable
{
    /**
     * Webpos Staff Index page.
     *
     * @var StaffIndex
     */
    private $staffsIndex;
    /**
     * @var StaffNews
     */
    private $staffsNew;

    /**
     * Inject Staff pages.
     *
     * @param StaffIndex $staffsIndex
     * @return void
     */
    public function __inject(
        StaffIndex $staffsIndex,
        StaffNews $staffsNew
    )
    {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
    }

    public function test(Staff $staff)
    {
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getPageActionsBlock()->addNew();
        sleep(1);
        $this->staffsNew->getStaffsForm()->fill($staff);
        $this->staffsNew->getFormPageActionsStaff()->saveAndContinue();
        sleep(1);

        return ['fields' => $staff->getData()];
    }
}

