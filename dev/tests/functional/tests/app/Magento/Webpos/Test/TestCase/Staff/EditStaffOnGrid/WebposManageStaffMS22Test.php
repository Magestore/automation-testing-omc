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

class WebposManageStaffMS22Test extends Injectable
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
    ) {
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
        $this->staffsIndex->getStaffsGrid()->getRowByEmail($staff->getEmail())->click();
        sleep(1);
        $this->staffsIndex->getStaffsGrid()->getActionButtonEditing('Cancel')->click();
        $this->staffsIndex->getStaffsGrid()->waitLoader();
        sleep(1);
        $staffId = $this->staffsIndex->getStaffsGrid()->getAllIds()[0];

        return ['dataDisplay' =>
            [
                'staff_id' => $staffId,
                'username' => $staff->getUsername(),
                'email' => $staff->getEmail(),
                'display_name' => $staff->getDisplayName(),
                'location' => $staff->getLocationId()[0],
                'role' => $staff->getRoleId(),
                'status' => $staff->getStatus(),

            ]];
    }
}

