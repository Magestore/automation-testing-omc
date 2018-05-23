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
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleEdit;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AdminSessionManagementLR30Test
 * Precondition:
 * - Loged in backend
 * - In the  webpos settings page, set the Need to create session before working field to Yes
 *
 * Steps:
 * 1. In the backend, user assigns lock/unlock permission to staff (ex: Staff A)
 * 2. On webpos, login webpos with staff account (Staff A) that is assigned permission to lock/unlock register
 * 3. Staff A locks register by entering correct security PIN
 * 4. In the backend, user change permission of Staff A (Staff A not assigned permission to lock/unlock register
 * 5. On the unlock screen, Staff A enters correct security PIN
 *
 * Acceptance:
 * 3. The register is locked successfully
 * 4. Staff permission is changed successfully
 * 5. Can not unlock register and simultaneously, an alert message is displayed:
 * "Permission denied. Please contact Administrator to unlock the register"
 *
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs
 */
class AdminSessionManagementLR30Test extends Injectable
{
    /**
     * @var WebposRoleIndex
     */
    protected $webposRoleIndex;

    /**
     * @var WebposRoleNew
     */
    protected $webposRoleNew;

    /**
     * @var WebposRoleEdit
     */
    protected $webposRoleEdit;

    /**
     * @var WebposIndex
     */
    protected $webposIndex;


    public function __inject(
        WebposRoleIndex $webposRoleIndex,
        WebposIndex $webposIndex,
        WebposRoleNew $webposRoleNew,
        WebposRoleEdit $webposRoleEdit
    )
    {
        $this->webposRoleIndex = $webposRoleIndex;
        $this->webposIndex = $webposIndex;
        $this->webposRoleNew = $webposRoleNew;
        $this->webposRoleEdit = $webposRoleEdit;
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
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
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

        // lock register
        $posPin = $pos->getPin();
        for ($i = 0; $i < 4; $i++) {
            $this->webposIndex->getCLockRegister()->getInputLockRegisterPin($i + 1)->setValue($posPin[$i]);
        }
        $this->webposIndex->getCLockRegister()->waitForPopupLockRegisterNotVisible();
        $this->webposIndex->getMsWebpos()->waitForCheckoutLoaderNotVisible();
        $this->webposIndex->getMsWebpos()->waitForLockScreen();
        $this->assertTrue(
            $this->webposIndex->getLockScreen()->isVisible(),
            'The register is not locked successfully'
        );

        $this->webposRoleIndex->open();
        $this->webposRoleIndex->getRoleGrid()->searchAndOpen(['display_name' => $webposRole->getDisplayName()]);
        $this->webposRoleEdit->getRoleForm()->openTab('permission');
        $roleResourcesClick = [
            'Magestore_Webpos::lock_unlock_register'
        ];
        $this->webposRoleEdit->getRoleForm()->getRoleResources($roleResourcesClick[0]);
        $this->webposRoleEdit->getFormPageActions()->save();
        $this->assertEquals(
            'Role was successfully saved',
            $this->webposRoleIndex->getMessagesBlock()->getSuccessMessage(),
            'Staff permission is not changed successfully'
        );

        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->waitForLockScreen();
        // unlock register
        for ($i = 0; $i < 4; $i++) {
            $this->webposIndex->getLockScreen()->getInputUnLockRegisterPin($i + 1)->setValue($posPin[$i]);
        }
        $this->webposIndex->getMsWebpos()->waitForCheckoutLoaderNotVisible();
        $this->assertEquals(
            'Error: Permission denied. Please contact Administrator to unlock the register.',
            $this->webposIndex->getToaster()->getWarningMessage()->getText(),
            'Message alert not unlock not correct'
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