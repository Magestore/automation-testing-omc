<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Staff\EditStaff;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Mtf\Fixture\FixtureFactory;

/**
 * Edit staff
 * Testcase MS40 - Check [Cancel] button
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Choose Locations] button
 *
 * Acceptance Criteria
 * 2. Show [Choose locations] page including:
 * - 2 buttons: Cancel, Add selected locations
 * - Filter function
 * - A grid shows the locations that dont link to any warehouse
 *
 * Class WebposManageStaffMS40Test
 * @package Magento\Webpos\Test\TestCase\Staff\EditStaff
 */
class WebposManageStaffMS40Test extends Injectable
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

    public function test(FixtureFactory $fixtureFactory)
    {
        // Preconditions:
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staffMS21']);
        $staff->persist();
        // Steps
        $this->staffsIndex->open();
        $this->staffsIndex->getStaffsGrid()->search(['email' => $staff->getEmail()]);
        $this->staffsIndex->getStaffsGrid()->getRowByEmail($staff->getEmail())->find('.action-menu-item')->click();
        sleep(1);
        $this->staffsNew->getStaffsForm()->setPassword('testavc123');
        $this->staffsNew->getStaffsForm()->setConfimPassword('testavc123ds');
        $this->staffsNew->getFormPageActionsStaff()->save();
        sleep(1);
    }
}

