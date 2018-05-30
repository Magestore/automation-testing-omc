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
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AdminSessionManagementLR61Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs
 *
 * Precondition:
 * - Loged in webpos with POS staff that is assigned permission to lock/unlock register
 * -  Have a POS which is locked
 *
 * Steps:
 * 1. In backend panel, go to Manage POS page, select a locked POS
 * 2. In the locked POS detail page, set the Enable option to lock register field to No
 * 3. Reload webpos and check the locked POS on webpos
 * 4. Check the status of locked POS on backend
 *
 * Acceptance:
 * 3. The locked POS is automatically unlocked
 * 4. POS status changes from Locked to Enabled
 *
 */
class AdminSessionManagementLR61Test extends Injectable
{
    /**
     * @var WebposRoleNew
     */
    protected $webposRoleNew;

    /**
     * @var WebposIndex
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
        WebposIndex $webposIndex,
        WebposRoleNew $webposRoleNew,
        PosIndex $posIndex,
        PosEdit $posEdit
    )
    {
        $this->webposIndex = $webposIndex;
        $this->webposRoleNew = $webposRoleNew;
        $this->posIndex = $posIndex;
        $this->posEdit = $posEdit;
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
            'Magento\Webpos\Test\TestStep\AdminLockPosStep',
            [
                'posName' => $pos->getPosName()
            ]
        )->run();

        // steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->searchAndOpen(
            [
                'pos_name' => $pos->getPosName()
            ]
        );
        $this->posEdit->getPosForm()->getEnableOptionToLockRegister()->setValue("No");
        $this->posEdit->getFormPageActions()->save();

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
        $this->assertFalse(
            $this->webposIndex->getLockScreen()->isVisible(),
            'Pos still locked'
        );

        $this->posIndex->open();
        $this->posIndex->getPosGrid()->searchAndOpen(
            [
                'pos_name' => $pos->getPosName()
            ]
        );
        $this->assertEquals(
            'Enabled',
            $this->posEdit->getPosForm()->getStatus()->getValue(),
            'Pos status is not Enabled'
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