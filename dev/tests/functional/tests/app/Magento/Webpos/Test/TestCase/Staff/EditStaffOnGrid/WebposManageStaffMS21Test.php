<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Staff\EditStaffOnGrid;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 *  Check tax amount when ordering with shipping fee
 * Testcase MS21 - Check Tax amount on Print window
 *
 * Precondition
 * 1. Go to backend > Configuration > Sales > Tax:
 * Setting all fields: tick on [Use system value] checkbox
 *
 * Steps
 * 1. Login webpos as a staff
 * 2. Add some  products and select a customer to meet tax condition
 * 3. Select a shipping method with fee
 * 4. Place order successfully with completed status
 * 5. Go to Order detail
 * 6. Click on [Print] button
 *
 * Acceptance Criteria
 * 6. Tax amount will be show exactly on print window:
 * Tax amount = Subtotal x Tax rate
 *
 * Class WebposManageStaffMS21Test
 * @package Magento\Webpos\Test\TestCase\Staff\EditStaffOnGrid
 */
class WebposManageStaffMS21Test extends Injectable
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
     * @param Staff $staff
     */
    public function test(Staff $staff)
    {
        // Preconditions:
        $staff->persist();

        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getStaffsGrid()->search(['email' => $staff->getEmail()]);
        $this->staffsIndex->getStaffsGrid()->getRowByEmail($staff->getEmail())->click();
        $this->staffsIndex->getStaffsGrid()->waitLoader();
        sleep(1);
    }
}

