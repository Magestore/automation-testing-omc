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
 * Testcase MS45 - Check [Cancel] button
 *
 * Precondition: Exist at least 2 location that doesnt link to any warehouse
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Choose Locations] button
 * 3. Click on Filter button
 * 4. Input data into some fields that dont match any record
 * 5. Click on [Apply Filters] button
 *
 * Acceptance Criteria
 * 5.
 * - Close Filter form
 * - Show message: "We couldn't find any records." on the Grid
 *
 * Class WebposManageStaffMS45Test
 * @package Magento\Webpos\Test\TestCase\Staff\EditStaff
 */
class WebposManageStaffMS45Test extends Injectable
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
        $this->staffsNew->getStaffsForm()->setUserName('test' . $staff->getUsername());
        $this->staffsNew->getStaffsForm()->setDisplayName('test' . $staff->getDisplayName());
        $this->staffsNew->getStaffsForm()->setEmailAddress('test' . $staff->getEmail());
        $this->staffsNew->getStaffsForm()->setPinCode('0123');
        $this->staffsNew->getFormPageActionsStaff()->saveAndContinue();
        sleep(1);

        $fields = $staff->getData();
        $fields['customer_group'] = $fields['customer_group'][0];
        $fields['location_id'] = $fields['location_id'][0];
        $fields['pos_ids'] = $fields['pos_ids'][0];
        $fields['email'] = 'test' . $staff->getEmail();
        $fields['display_name'] = 'test' . $staff->getDisplayName();
        $fields['username'] = 'test' . $staff->getUsername();
        $fields['pin'] = '0123';
        return ['fields' => $fields];
    }
}

