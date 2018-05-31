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
 * Testcase MS37 - Change warehouse on the grid
 *
 * Precondition:
 * Exist at least 2 records on the grid of [mapping locations -warehouses] page
 * (ex: Location 1 - warehouse 1
 * Location 2 - warehouse 2)
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Change the warehouse of 1 record to another warehouse that is assigning to the another location
 * (ex: Location 1 - warehouse 2)
 * 3. Click [Save] button
 *
 * Acceptance Criteria
 * 2. The grid will be updated data:
 * Location 1 - warehouse 2
 * Location 2 - warehouse 1
 * 3. Data will be saved successfully and show message "The mapping warehouses - locations have been saved."
 *
 * Class WebposManageStaffMS37Test
 * @package Magento\Webpos\Test\TestCase\Staff\EditStaff
 *
 */
class WebposManageStaffMS37Test extends Injectable
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
        $this->staffsNew->getFormPageActionsStaff()->save();
        sleep(1);
        $fields = $staff->getData();
        $fields['customer_group'] = $fields['customer_group'][0];
        $fields['location_id'] = $fields['location_id'][0];
        $fields['pos_ids'] = $fields['pos_ids'][0];
        return ['dataStaff' => $fields];
    }
}

