<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 02/05/2018
 * Time: 16:07
 */


namespace Magento\Webpos\Test\TestCase\Staff\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;

/**
 * Class ManageStaffPageMS01Test
 * Precondition: 1. Go to backend
 * Steps:  "1. Go to Sales > Manage Staffs
    2. Click on [Add Staff] button"
 * Acceptance:
 * "2. Display [New Staff] page including:
- Title: New Staff
- Staff information contains fields: User Name, Password, Password confirmation, Display Name, Email Address, PIN code (App only)
- User Settings contain fields: Customer group, Location, Role, Status, POS
- Buttons: Back, Reset, Save and continue Edit, Save"
 * @package Magento\Webpos\Test\TestCase\Staff\CheckGUI
 */
class AddNewStaffPageMS02Test extends Injectable
{
    /**
     * Webpos Staff News page.
     *
     * @var StaffNews
     */
    private $staffNews;

    /**
     * Inject Staff News pages.
     *
     * @param StaffNews $staffNews
     * @return void
     */
    public function __inject(
        StaffNews $staffNews
    ) {
        $this->staffNews = $staffNews;
    }

    /**
     * Create Staff group test.
     *
     * @return void
     */
    public function test()
    {
        // Steps
        $this->staffNews->open();
    }
}