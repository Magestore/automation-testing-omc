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
 * Testcase MS29 - Check [Reset] button
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps
 * 1. Click on [Add Staff] button
 * 2. Fill out correctly all fields
 * 3. Click on [Reset] button
 *
 * Acceptance Criteria
 * 3. Reset data in all fileds to default values
 *
 * Class WebposManageStaffMS29Test
 * @package Magento\Webpos\Test\TestCase\Staff\AddStaff
 */
class WebposManageStaffMS29Test extends Injectable
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
        $this->staffsNew->getFormPageActionsStaff()->reset();
        sleep(1);

        return ['fields' => [
            'display_name' => '',
            'username' => '',
            'email' => '',
            'pin' => '0000',
            'customer_group' => '',
            'location_id' => '',
            'role_id' => 'admin',
            'status' => 'Enabled',
            'pos_ids' => ''
        ]];

    }
}

