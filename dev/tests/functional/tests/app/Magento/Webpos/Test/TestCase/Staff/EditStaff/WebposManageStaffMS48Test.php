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
use Magento\Webpos\Test\Constraint\Adminhtml\Staff\Form\AssertPopupDelete;

/**
 * Edit staff
 * Testcase MS48 - Check [Delete] button
 *
 * Precondition:
 * Exist at least 1 staff on the grid of Manage staffs page
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps
 * 1. Click on [Edit] button to edit the staff
 * 2. Click on [Delete] button
 * 3. Click on [X] button on the confirmation popup
 *
 * Acceptance Criteria
 * 3. Close the confirmation popup and still stay on the Edit staff page
 *
 * Class WebposManageStaffMS48Test
 * @package Magento\Webpos\Test\TestCase\Staff\EditStaff
 */
class WebposManageStaffMS48Test extends Injectable
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
     * @var AssertPopupDelete
     */
    private $assertPopupDelete;

    /**
     * Inject Staff pages.
     *
     * @param StaffIndex $staffsIndex
     * @return void
     */
    public function __inject(
        StaffIndex $staffsIndex,
        StaffNews $staffsNew,
        AssertPopupDelete $assertPopupDelete
    )
    {
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
        $this->assertPopupDelete = $assertPopupDelete;
    }

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

        //Check open popup when click delete
        $message = 'Are you sure you want to do this?';
        $this->assertPopupDelete->processAssert($this->staffsNew,
            ['tag' => 'open', 'message' => $message]);

        //Click X exit
        $this->staffsNew->getModalsWrapper()->getXButton()->click();
        sleep(1);

        return [
            'info' => ['tag' => 'close',
                'message' => $message
            ]
        ];
    }
}

