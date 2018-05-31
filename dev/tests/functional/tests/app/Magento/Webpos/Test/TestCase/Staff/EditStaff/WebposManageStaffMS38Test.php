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

/**
 * Edit staff
 * Testcase MS38 - Check [Remove] action
 *
 * Precondition:
 * sExist at least 2 records on the grid of [mapping locations -warehouses] page
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Remove] action on the record
 * 3. Click on [Cancel] button
 * 4. Click on [Mapping Locations - Warehouses] again
 *
 * Acceptance Criteria
 * 2. That record will be removed from the grid
 * 3. back to Location page
 * 4. The removed record still shows on the grid
 *
 *
 * Class WebposManageStaffMS38Test
 * @package Magento\Webpos\Test\TestCase\Staff\EditStaff
 */
class WebposManageStaffMS38Test extends Injectable
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
        $this->staffsNew->getStaffsForm()->setPassword($staff->getPassword());
        $this->staffsNew->getStaffsForm()->setConfimPassword($staff->getPasswordConfirmation());
        $this->staffsNew->getStaffsForm()->setEmailAddress('test' . $staff->getEmail());
        $this->staffsNew->getStaffsForm()->setDisplayName('test' . $staff->getDisplayName());
        $this->staffsNew->getFormPageActionsStaff()->save();
        sleep(1);

        $fields = $staff->getData();
        $fields['customer_group'] = $fields['customer_group'][0];
        $fields['location_id'] = $fields['location_id'][0];
        $fields['pos_ids'] = $fields['pos_ids'][0];
        $fields['email'] = 'test' . $staff->getEmail();
        $fields['display_name'] = 'test' . $staff->getDisplayName();
        return ['dataStaff' => $fields];
    }
}

