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

/**
 * Add Staff
 * Testcase MS24 - Click on [Save button] without filling out all fields
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps
 * 1. Click on [Add Staff] button
 * 2. Click on [Save] button
 *
 * Acceptance Criteria
 * 2.
 * - Create staff unsuccessfully
 * - Show message: "This is a required field." under all required fields
 *
 * Class WebposManageStaffMS24Test
 * @package Magento\Webpos\Test\TestCase\Staff\AddStaff
 */
class WebposManageStaffMS24Test extends Injectable
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
     * Test steps
     */
    public function test()
    {
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getPageActionsBlock()->addNew();
        sleep(1);
        $this->staffsNew->getFormPageActions()->save();
        sleep(1);
    }
}

