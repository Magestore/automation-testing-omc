<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 25/05/2018
 * Time: 15:29
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\ForceSignOut;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffEdit;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 * Class AdminSessionManagementFS02Test
 *
 * Precondition:
 * - Manage staff permission is assigned to magento users
 * - POS staff is loging in on POS
 *
 * Steps:
 * 1. Login backend with user assigned to Manage staff permssion
 * 2. Go to Manage staff page (path:Sales -> Webpos -> Manage staff)
 * 3. From Manage staff page, select a staff that is logging in POS
 * 4. In staff detail page, observe the position of Force sign out button
 *
 * Acceptance:
 * 4. The Force sign out button is placed between Reset button and Save and continue edit button
 *
 * @package Magento\Webpos\Test\TestCase\SessionManagement\ForceSignOut
 */
class AdminSessionManagementFS02Test extends Injectable
{
    /**
     * @var StaffIndex $staffIndex
     */
    protected $staffIndex;

    /**
     * @var StaffEdit $staffEdit
     */
    protected $staffEdit;

    public function __inject(
        StaffIndex $staffIndex,
        StaffEdit $staffEdit
    )
    {
        $this->staffIndex = $staffIndex;
        $this->staffEdit = $staffEdit;
    }

    public function test(
        Pos $pos,
        FixtureFactory $fixtureFactory
    )
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_session_before_working']
        )->run();

        /**@var Location $location */
        $location = $fixtureFactory->createByCode('location', ['dataset' => 'default']);
        $location->persist();
        $locationId = $location->getLocationId();
        $posData = $pos->getData();
        $posData['location_id'] = [$locationId];
        /**@var Pos $pos */
        $pos = $fixtureFactory->createByCode('pos', ['data' => $posData]);
        $pos->persist();
        $posId = $pos->getPosId();
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'default']);
        $staffData = $staff->getData();
        $staffData['location_id'] = [$locationId];
        $staffData['pos_ids'] = [$posId];
        /**@var Staff $staff */
        $staff = $fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
                'hasOpenSession' => false,
                'hasWaitOpenSessionPopup' => false
            ]
        )->run();

        $this->staffIndex->open();
        $this->staffIndex->getStaffsGrid()->searchAndOpen(
            [
                'username' => $staff->getUsername()
            ]
        );
        $this->assertTrue(
            $this->staffEdit->getFormPageActions()->getForceSignOutButton()->isVisible(),
            'Button Force signout not visible'
        );
    }

    public function tearDown()
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'setup_session_before_working_to_no']
        )->run();
    }
}