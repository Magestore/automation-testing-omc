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
 * Testcase MS32 - Check validate Password fields
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps
 * 3.
 * 1. Click on [Edit] button to edit the Location
 * 2. Click on [Delete] button
 * 3. Click on [OK] button on the confirmation popup
 *
 * Acceptance Criteria
 * 3.
 * - Create staff unsuccessfully
 * - Show message: "Please enter 7 or more characters, using both numeric and alphabetic." under [Password]  textbox
 *
 * Class WebposManageStaffMS32Test
 * @package Magento\Webpos\Test\TestCase\Staff\CheckValidation
 */
class WebposManageStaffMS32Test extends Injectable
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

