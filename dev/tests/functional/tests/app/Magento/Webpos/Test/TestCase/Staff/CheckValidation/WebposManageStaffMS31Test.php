<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 17/02/2018
 * Time: 19:27
 */

namespace Magento\Webpos\Test\TestCase\Staff\CheckValidation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;

/**
 * Check validation
 * Testcase MS31 - Check validate Password fields
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps
 * 1. Click on [Add Staff] button
 * 2. Input data into all required fields with conditions:
 * - [Password] and [Password confirmation]: enter 7 or more characters, using both numeric and alphabetic.
 * - [Password] and [Password confirmation] don't match
 * - Other fields are inputted correctly
 * 3. Click on [Save] button
 *
 * Acceptance Criteria
 * 3.
 * - Create staff unsuccessfully
 * - Show message: "Please make sure your passwords match." under [Password confirmation] textbox
 *
 *
 * Class WebposManageStaffMS31Test
 * @package Magento\Webpos\Test\TestCase\Staff\CheckValidation
 */
class WebposManageStaffMS31Test extends Injectable
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
        $this->staffsNew->getFormPageActions()->save();
        sleep(1);
    }
}

