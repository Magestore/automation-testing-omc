<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 27/04/2018
 * Time: 10:55
 */

namespace Magento\Webpos\Test\TestCase\Staff\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 * Class ManageStaffPageMS01Test
 * Precondition: 1. Go to backend
 * Steps: 1. Go to Sales > Manage Staffs
 * Acceptance:
 * 1. Display [Manage Staffs] page including:
    - Titles: Staff
    - Buttons: Add Staff
    - The grid with columns: ID, Username, Email, Display name, Location, Role, Status, Action
    - Mass actions contains: Delete and Changes status
    - Filter function
 * @package Magento\Webpos\Test\TestCase\Staff\CheckGUI
 */
class ManageStaffPageMS01Test extends Injectable
{
    /**
     * Webpos Staff Index page.
     *
     * @var StaffIndex
     */
    private $staffIndex;

    /**
     * Inject Staff pages.
     *
     * @param StaffIndex $staffsIndex
     * @return void
     */
    public function __inject(
        StaffIndex $staffsIndex
    ) {
        $this->staffIndex = $staffsIndex;
    }

    /**
     * Create Staff group test.
     *
     * @return void
     */
    public function test()
    {
        // Steps
        $this->staffIndex->open();
    }
}