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
use Magento\Webpos\Test\Constraint\Adminhtml\Staff\Grid\AssertMessageEditSuccessOnGrid;

/**
 * Check tax amount when ordering with shipping fee
 * Testcase MS23 - Check Tax amount when creating a partial refund
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
 * 5. Go to Order detail > click to refund
 * 6. On refund pupup, create a partial refund
 * 7. Create refund extant items
 *
 * Acceptance Criteria
 * 6. Refund successfully with exact amount
 * Total refunded = [SUM(Row total of refunded product / Ordered Qty * Refunded Qty) + Adjust refund + Refund shipping - Adjust fee]
 * 7. Refund successfully
 *
 * Class WebposManageStaffMS23Test
 * @package Magento\Webpos\Test\TestCase\Staff\EditStaffOnGrid
 */
class WebposManageStaffMS23Test extends Injectable
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
     * @param StaffIndex
     * @return void
     */
    /**
     * @var AssertMessageEditSuccessOnGrid
     */
    private $assertCheckMessageSuccess;

    public function __inject(
        StaffIndex $staffsIndex,
        AssertMessageEditSuccessOnGrid $assertCheckMessageSuccess
    )
    {
        $this->staffsIndex = $staffsIndex;
        $this->assertCheckMessageSuccess = $assertCheckMessageSuccess;
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
        $this->staffsIndex->getStaffsGrid()->getRowByEmail($staff->getEmail())->click();
        $this->staffsIndex->getStaffsGrid()->setDisplayName('test' . $staff->getDisplayName());
        $this->staffsIndex->getStaffsGrid()->setEmail('test' . $staff->getEmail());
        $this->staffsIndex->getStaffsGrid()->getActionButtonEditing('Save')->click();
        $this->staffsIndex->getStaffsGrid()->waitLoader();
        sleep(1);

        $staffId = $this->staffsIndex->getStaffsGrid()->getAllIds()[0];
        return ['dataDisplay' =>
            [
                'staff_id' => $staffId,
                'username' => $staff->getUsername(),
                'email' => 'test' . $staff->getEmail(),
                'display_name' => 'test' . $staff->getDisplayName(),
                'location' => $staff->getLocationId()[0],
                'role' => $staff->getRoleId(),
                'status' => $staff->getStatus(),

            ]];
    }
}

