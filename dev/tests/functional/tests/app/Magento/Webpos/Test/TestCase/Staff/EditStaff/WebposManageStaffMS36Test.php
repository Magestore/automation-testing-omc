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

/**
 * Edit staff
 * Testcase MS36 - Check data on the grid
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Check data on the grid
 *
 *
 * Acceptance Criteria
 * 2.
 * - The grid will  shown all locations and coresp  onding warehouses
 * - The grid will not shown the locations that dont link to any warehouse
 *
 * Class WebposManageStaffMS36Test
 * @package Magento\Webpos\Test\TestCase\Staff\EditStaff
 */
class WebposManageStaffMS36Test extends Injectable
{
    /**
     * Webpos Staff Index page.
     *
     * @var StaffIndex
     */
    private $staffsIndex;

    /**
     * Inject Staff pages.
     *
     * @param StaffIndex $staffsIndex
     * @return void
     */
    public function __inject(
        StaffIndex $staffsIndex
    )
    {
        $this->staffsIndex = $staffsIndex;
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
        $fields = $staff->getData();
        $fields['customer_group'] = $fields['customer_group'][0];
        $fields['location_id'] = $fields['location_id'][0];
        $fields['pos_ids'] = $fields['pos_ids'][0];
        return ['fields' => $fields];
    }
}

