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

        /**@var Location $location*/
        $location = $fixtureFactory->createByCode('location', ['dataset' => 'default']);
        $location->persist();
        $locationId = $location->getLocationId();
        $posData = $pos->getData();
        $posData['location_id'][] = $locationId;
        /**@var Pos $pos*/
        $pos = $fixtureFactory->createByCode('pos', ['data' => $posData]);
        $pos->persist();
        $posId = $pos->getPosId();
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
        $staffData = $staff->getData();
        $staffData['location_id'][] = $locationId;
        $staffData['pos_ids'][] = $posId;
        /**@var Staff $staff*/
        $staff = $fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos
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