<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Staff\EditStaff;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Mtf\Client\Locator;

/**
 * Edit staff
 * Testcase MS49 - Check [Delete] button
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps
 * 1. Click on [Edit] button to edit the staff
 * 2. Click on [Delete] button
 * 3. Click on [OK] button on the confirmation popup
 *
 * Acceptance Criteria
 * 3.
 * - Delete staff successfully
 * - Back to Manage staffs page and show message: "Staff was successfully deleted"
 *
 *
 * Class WebposManageStaffMS49Test
 * @package Magento\Webpos\Test\TestCase\Staff\EditStaff
 */
class WebposManageStaffMS49Test extends Injectable
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

    /**
     * Create Staff group test.
     *
     * @param Staff $location
     * @return void
     */
    public function test(Staff $staff)
    {
        // Preconditions:
        $staff->persist();
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getStaffsGrid()->search(['email' => $staff->getEmail()]);
        $this->staffsIndex->getStaffsGrid()->getRowByEmail($staff->getEmail())->find('.action-menu-item')->click();
        sleep(1);
        $this->staffsNew->getFormPageActionsStaff()->deleteButton()->click();
        $this->staffsNew->getModalsWrapper()->getOkButton()->click();
        sleep(2);
        $this->staffsIndex->open();
        $this->staffsIndex->getStaffsGrid()->search([
            'email' => $staff->getEmail()
        ]);
        $this->staffsIndex->getStaffsGrid()->waitLoader();
        sleep(1);
    }
}

