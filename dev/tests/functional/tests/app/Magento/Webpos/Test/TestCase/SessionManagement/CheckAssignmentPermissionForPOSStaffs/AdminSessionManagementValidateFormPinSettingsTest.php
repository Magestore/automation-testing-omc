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
 * Class AdminSessionManagementValidateFormPinSettingsTest
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs
 *
 * Precondition:
 * - In the webpos settings page, set the Need to create session before working field to Yes
 * - POS staff have been assigned to specific POS (this POS is enabled Lock register)
 * - POS staff have been assigned with the permission to edit security PIN
 *
 * Steps:
 * 1. POS staff login webpos, select location and POS
 * 2. On the left menu -> click on General -> Select Lock Register menu
 * 3. Leaving the POS account password field blank, fill data for remaining field
 * 4. Click on Save button
 *
 * Acceptance:
 * 4. Saving the change unsuccessfully and simultaneously, show alert message: "Please enter password of your POS account to confirm changes"
 *
 */
class AdminSessionManagementValidateFormPinSettingsTest extends Injectable
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
        $menuItemLockRegister,
        FixtureFactory $fixtureFactory,
        $testCaseId
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
            'Magestore_Webpos::edit_pin'
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

        $this->webposIndex->getCMenu()->general();
        sleep(1);
        $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($menuItemLockRegister)->click();
        $this->webposIndex->getGeneralSettingContentRight()->waitForPinSettingsFormVisible();
        $message = "";
        if ($testCaseId === "LR33") {
            $this->webposIndex->getGeneralSettingContentRight()->getSecurityPIN()->setValue($pos->getPin());
            $message = "Please enter password of your POS account to confirm changes.";
        } else if ($testCaseId === "LR34") {
            $this->webposIndex->getGeneralSettingContentRight()->getPOSAccountPassword()->setValue($staff->getPassword());
            $message = "Please fill in a 4-digit security PIN";
        } else if ($testCaseId === "LR36") {
            $this->webposIndex->getGeneralSettingContentRight()->getPOSAccountPassword()->setValue("asd3@1");
            $this->webposIndex->getGeneralSettingContentRight()->getSecurityPIN()->setValue($pos->getPin());
            $message = "Wrong password. Please try again!";
        } else if ($testCaseId === "LR39") {
            $this->webposIndex->getGeneralSettingContentRight()->getPOSAccountPassword()->setValue($staff->getPassword());
            $this->webposIndex->getGeneralSettingContentRight()->getSecurityPIN()->setValue($pos->getPin());
            $this->assertEquals('password',
                $this->webposIndex->getGeneralSettingContentRight()->getSecurityPIN()->getAttribute("type"),
                'Security PIN not password'
            );
        } else if ($testCaseId === "LR40") {
            $this->webposIndex->getGeneralSettingContentRight()->getPOSAccountPassword()->setValue($staff->getPassword());
            $this->webposIndex->getGeneralSettingContentRight()->getSecurityPIN()->setValue("asd@");
            $message = "Please use numbers only.";
        } else if ($testCaseId === "LR41") {
            $this->webposIndex->getGeneralSettingContentRight()->getPOSAccountPassword()->setValue($staff->getPassword());
            $this->webposIndex->getGeneralSettingContentRight()->getSecurityPIN()->setValue("1");
            $message = "Security PIN contains only 4 numeric characters in length";
        } else if ($testCaseId === "LR42") {
            $this->webposIndex->getGeneralSettingContentRight()->getPOSAccountPassword()->setValue($staff->getPassword());
            $this->webposIndex->getGeneralSettingContentRight()->getSecurityPIN()->setValue("12345");
            $message = "Security PIN contains only 4 numeric characters in length";
        } else if ($testCaseId === "LR43") {
            $this->webposIndex->getGeneralSettingContentRight()->getPOSAccountPassword()->setValue($staff->getPassword());
            $this->webposIndex->getGeneralSettingContentRight()->getSecurityPIN()->setValue($pos->getPin());
            $message = "Security PIN was successfully changed.";
        }
        $this->webposIndex->getGeneralSettingContentRight()->getLockRegisterButtonSave()->click();
        $this->webposIndex->getMsWebpos()->waitForCheckoutLoaderNotVisible();
        return [
            'message' => $message
        ];
    }

    public function tearDown()
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'setup_session_before_working_to_no']
        )->run();
    }
}