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
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffEdit;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AdminSessionManagementFS03Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\ForceSignOut
 *
 * Precondition:
 * - Manage staff permission is assigned to magento users
 * - POS staff is loging in on POS
 *
 * Steps:
 * 1. Login webpos with POS staff account (ex: staff A) -> select a specify POS (POS 1)
 * 2. Login backend with user that is assigned to Manage staff permssion
 * 3. Go to Manage staff page (path:Sales -> Webpos -> Manage staff)
 * 4. From Manage staff page, select a staff (staff A) that is logging in POS (POS 1)
 * 5. In staff A detail page, click on Force sign out button
 * 6. Check status of staff A on webpos
 * 7. In backend, go to Manage POS page, check the current staff field of POS 1
 *
 * Acceptance:
 * 5. Force sign-out successfully, and a message is appeared: staff A was logged out of the POS A and simultaneously, hide the Force Sign-out button.
 * 6. Automcatically log staff A out of webpos, and show the login screen
 * 7. Not showing staff name
 *
 */
class AdminSessionManagementFS03Test extends Injectable
{
    /**
     * @var StaffIndex $staffIndex
     */
    protected $staffIndex;

    /**
     * @var StaffEdit $staffEdit
     */
    protected $staffEdit;

    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var PosEdit
     */
    protected $posEdit;

    /**
     * @var PosIndex
     */
    protected $posIndex;

    public function __inject(
        StaffIndex $staffIndex,
        StaffEdit $staffEdit,
        WebposIndex $webposIndex,
        PosIndex $posIndex,
        PosEdit $posEdit
    )
    {
        $this->staffIndex = $staffIndex;
        $this->staffEdit = $staffEdit;
        $this->webposIndex = $webposIndex;
        $this->posIndex = $posIndex;
        $this->posEdit = $posEdit;
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
                'hasOpenSession' => true,
                'hasWaitOpenSessionPopup' => true
            ]
        )->run();

        $this->staffIndex->open();
        $this->staffIndex->getStaffsGrid()->searchAndOpen(
            [
                'username' => $staff->getUsername()
            ]
        );
        $this->staffEdit->getFormPageActions()->getForceSignOutButton()->click();
        $this->assertEquals(
            'Staff account was logged out of the current POS.',
            $this->staffEdit->getMessagesBlock()->getSuccessMessage(),
            'Staff yet logged out pos'
        );
        $this->assertFalse(
            $this->staffEdit->getFormPageActions()->getForceSignOutButton()->isVisible(),
            'Button Force signout not hidden'
        );
        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
        $this->assertTrue(
            $this->webposIndex->getLoginForm()->isVisible(),
            'login form not visible'
        );

        $this->posIndex->open();
        $this->posIndex->getPosGrid()->searchAndOpen(
            [
                'pos_name' => $pos->getPosName()
            ]
        );
        $this->assertEquals(
            '',
            trim($this->posEdit->getPosForm()->getCurrentStaff()->getValue()),
            'pos has staff login'
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