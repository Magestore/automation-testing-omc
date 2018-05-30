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
 * Class AdminSessionManagementLR57Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs
 *
 * Precondition:
 * - Loged in backend with user that is assigned permission to lock/unlock register
 *
 * Steps:
 * 1. From the backend panel -> go to the Manage POS page
 * 2. On POS list, select a POS
 * 3. On POS detail page, click on lock button
 * 4. Back on Manage POS page, observe the status of POS which is just locked
 *
 * Acceptance:
 * 3. Show the Unlock button
 * 4. Show the POS's status is Locked
 *
 */
class AdminSessionManagementLR57Test extends Injectable
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

        $this->posIndex->open();
        $this->posIndex->getPosGrid()->searchAndOpen(
            [
                'pos_name' => $pos->getPosName()
            ]
        );
        $this->assertEquals(
            'Locked',
            $this->posEdit->getPosForm()->getStatus()->getValue(),
            'Status of pos not Locked'
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