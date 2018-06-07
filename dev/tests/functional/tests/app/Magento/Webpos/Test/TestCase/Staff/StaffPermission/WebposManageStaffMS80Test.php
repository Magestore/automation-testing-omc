<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/9/2018
 * Time: 9:46 AM
 */

namespace Magento\Webpos\Test\TestCase\Staff\StaffPermission;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * *
 * Staff Permission
 * Testcase MS80 - Permission
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Roles
 * 2. Add a new role with permission:
 * + Open Shift
 * 3. Add new staff:
 * - Select the role that create on step 2
 * - Select location
 * 4. Go to settings webpos:
 * [Need to create session before working] = Yes
 *
 * Steps
 * 1. Login webpos by the staff who created on step 3 of [Precondition and setup steps] column
 * 2. Click on [Session management] menu
 * 3. Click to open a shift
 *
 * Acceptance Criteria
 * 3. Open a shift successfully
 *
 * Class WebposManageStaffMS80Test
 * @package Magento\Webpos\Test\TestCase\Staff\StaffPermission
 */
class WebposManageStaffMS80Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    private $webposIndex;

    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        //Config create session before working
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes']
        )->run();
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
        return ['staffData' => $staff->getData()];
    }

    /**
     * @param WebposRole $webposRole
     * @param $staffData
     */
    public function test(WebposRole $webposRole, $staffData)
    {
        //Create role and staff for role
        /**@var Location $location */
        $location = $this->fixtureFactory->createByCode('location', ['dataset' => 'default']);
        $location->persist();
        $locationId = $location->getLocationId();
        $posData['pos_name'] = 'Pos Test %isolation%';
        $posData['status'] = 'Enabled';
        $posData['location_id'][] = $locationId;
        /**@var Pos $pos */
        $pos = $this->fixtureFactory->createByCode('pos', ['data' => $posData]);
        $pos->persist();
        $posId = $pos->getPosId();
        $staffData['location_id'] = [$locationId];
        $staffData['pos_ids'] = [$posId];
        /**@var Staff $staff */
        $staff = $this->fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        $roleData = $webposRole->getData();
        $roleData['staff_id'][] = $staff->getStaffId();
        $role = $this->fixtureFactory->createByCode('webposRole', ['data' => $roleData]);
        $role->persist();
        //LoginTest
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
            ]
        )->run();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-open-shift"]');
        $this->assertTrue(
            $this->webposIndex->getListShift()->getFirstItemShift()->isVisible(),
            'Open a shift not successfully.'
        );

    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no']
        )->run();
    }

}

