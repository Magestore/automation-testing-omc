<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 22/05/2018
 * Time: 15:46
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AdminSessionManagementLR25Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs
 *
 * Precondition:
 * - Loged in backend
 * - In the  webpos settings page, set the Need to create session before working field to Yes
 * - From menu on the left side, select Sales menu , under Web POS > select Manage Role
 *
 * Steps:
 * 1. Add a new role or edit an existed role
 * 2. Open Permission tab
 * 3. In the Resource Access field, select option: custom
 * 4. Uncheck on Lock and Unlock register and Edit security PIN checkbox
 * 5. Open Staff List tab, select POS staff account by ticking on each it
 * 6. Click on Save button
 * 7. On webpos, login with POS staff account that is assigned role to Lock and Unlock register
 * 8. After loging in, select Location and POS (This POS is already configed to allow POS staff to lock register)
 * 9. Check webpos menu on left side
 * 10. From menu on left side -> select General -> check sub- menu
 *
 * Acceptance:
 * 9. Not showing the Lock Register menu under Logout menu
 * 10. Not showing the Lock Register sub-menu
 *
 */
class AdminSessionManagementLR25Test extends Injectable
{
    /**
     * @var WebposRoleNew
     */
    protected $webposRoleNew;

    /**
     * @var WebposIndex
     */
    protected $webposIndex;


    public function __inject(
        WebposIndex $webposIndex,
        WebposRoleNew $webposRoleNew
    )
    {
        $this->webposIndex = $webposIndex;
        $this->webposRoleNew = $webposRoleNew;
    }

    public function test(
        WebposRole $webposRole,
        Pos $pos,
        $menuItem,
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

        $this->webposRoleNew->open();
        $this->webposRoleNew->getRoleForm()->fill($webposRole);
        $this->webposRoleNew->getRoleForm()->openTab('user_section');
        /**
         * @var DataGrid $staffGridBlock
         */
        $staffGridBlock = $this->webposRoleNew->getRoleForm()->getTab('user_section')->getUserGrid();
        $staffGridBlock->searchAndSelect(
            [
                'username' => $staff->getUsername()
            ]
        );

        $this->webposRoleNew->getRoleForm()->openTab('permission');
        $this->webposRoleNew->getFormPageActions()->save();

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

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->assertFalse(
            $this->webposIndex->getCMenu()->getLockRegister()->isVisible(),
            'Lock register in Cmenu is visible'
        );
        $this->webposIndex->getCMenu()->general();
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($menuItem)->isVisible(),
            'Lock register in General Setting not visible'
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