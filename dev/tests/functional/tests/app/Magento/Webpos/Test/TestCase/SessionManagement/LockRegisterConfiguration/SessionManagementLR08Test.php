<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/12/2018
 * Time: 2:12 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\LockRegisterConfiguration;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class SessionManagementLR08Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\LockRegisterConfiguration
 *
 * Precondition and setup steps:
 * "- Loged in backend
 * - In the  webpos settings page, set the Need to create session before working field to Yes
 * - Go to Sales > Web POS > Manage POS > Open an any POS
 * - On the POS detail page, go to the Lock register session
 *
 * Steps:
 * 1. Set the Enable option to lock register field to No
 * 2. Click on Save button
 * 3. Login webpos with staff account
 * 4. Observe webpos menu on left side
 *
 * Acceptance Criteria
 * 4. Hide the Lock Register menu
 *
 */
class SessionManagementLR08Test extends Injectable
{
    /**
     * @var PosIndex
     */
    protected $posIndex;

    /**
     * @var PosEdit
     */
    protected $posEdit;

    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(PosIndex $posIndex, PosEdit $posEdit, WebposIndex $webposIndex)
    {
        $this->posIndex = $posIndex;
        $this->posEdit = $posEdit;
        $this->webposIndex = $webposIndex;
    }

    public function test(Pos $pos, FixtureFactory $fixtureFactory)
    {
        //Config create session before working
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes_MS57']
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
        // LoginTest webpos
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
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->assertFalse(
            $this->webposIndex->getCMenu()->getLockRegister()->isVisible(),
            'Lock Register menu is not hidden.'
        );

    }


    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }
}