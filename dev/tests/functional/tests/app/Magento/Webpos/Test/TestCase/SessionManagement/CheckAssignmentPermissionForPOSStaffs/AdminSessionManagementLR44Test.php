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
 * Class AdminSessionManagementLR44Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs
 *
 * Precondition:
 * - In the webpos settings page, set the Need to create session before working field to Yes
 * - POS staff have been assigned to specific POS (this POS is enabled Lock register)
 * - POS staff have been assigned with a specific permission to lock register
 *
 * Steps:
 * 1. POS staff login webpos, select location and POS
 * 2. On the left menu, click on Lock register menu
 * 3. Check confirmation popup
 *
 * Acceptance:
 * 2. Lock register confirmation popup is displayed, and mouse cursor focused on security PIN textbox
 * 3. Show confirmation popup include:
 * + 1 button: Cancel (is placed on top left corner of popup)
 * + 1 lock icon
 * + 1 text line with the content: Please enter security PIN to lock the register
 * + 4 small textboxes for entering security PIN
 *
 */
class AdminSessionManagementLR44Test extends Injectable
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
        $roleResourcesClick = [
            'Magestore_Webpos::lock_register'
        ];
        $this->webposRoleNew->getRoleForm()->getRoleResources($roleResourcesClick[0]);
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

        $this->webposIndex->getCMenu()->getLockRegister()->click();
        $this->webposIndex->getCLockRegister()->waitForPopupLockRegister();
    }

    public function tearDown()
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'setup_session_before_working_to_no']
        )->run();
    }
}