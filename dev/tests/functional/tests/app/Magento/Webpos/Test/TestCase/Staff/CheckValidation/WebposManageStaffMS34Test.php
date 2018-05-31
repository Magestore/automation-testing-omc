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
 * Mapping locations - Warehouses
 * Testcase MS34 - Check GUI
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 *
 * Acceptance Criteria
 * 1. Redirect to [Mapping Locations - Warehouses] page including:
 * - 3 buttons: Cancel, Save, Choose Locations
 * - A grid with 3 columns: Location, Warehouse (drop down style), Actions (Remove action
 *
 * Class WebposManageStaffMS34Test
 * @package Magento\Webpos\Test\TestCase\Staff\CheckValidation
 */
class WebposManageStaffMS34Test extends Injectable
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

//        return ['message' => 'Email '.$staff->getEmail().' is existed.'];
    }
}

