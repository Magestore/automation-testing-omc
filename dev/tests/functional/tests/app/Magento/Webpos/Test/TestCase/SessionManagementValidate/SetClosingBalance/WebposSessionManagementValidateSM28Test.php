<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/8/2018
 * Time: 2:13 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\SessionManagement\AssertCheckGUIOnSetClosingBalancePopup;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Staff;

/**
 * Class WebposSessionManagementValidateSM28Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposSessionManagementValidateSM28Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertCheckGUIOnSetClosingBalancePopup
     */
    protected $assertCheckGUIOnSetClosingBalancePopup;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertCheckGUIOnSetClosingBalancePopup $assertCheckGUIOnSetClosingBalancePopup
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertCheckGUIOnSetClosingBalancePopup $assertCheckGUIOnSetClosingBalancePopup
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertCheckGUIOnSetClosingBalancePopup = $assertCheckGUIOnSetClosingBalancePopup;
    }

    /**
     * @param Pos $pos
     * @param FixtureFactory $fixtureFactory
     */
    public function test(Pos $pos, FixtureFactory $fixtureFactory)
    {
        //Config create session before working
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes']
        )->run();

        /**@var Location $location*/
        $location = $fixtureFactory->createByCode('location', ['dataset' => 'default']);
        $location->persist();
        $locationId = $location->getLocationId();
        $posData = $pos->getData();
        $posData['location_id'] = [ $locationId ];
        /**@var Pos $pos*/
        $pos = $fixtureFactory->createByCode('pos', ['data' => $posData]);
        $pos->persist();
        $posId = $pos->getPosId();
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
        $staffData = $staff->getData();
        $staffData['location_id'] = [ $locationId ];
        $staffData['pos_ids'] = [ $posId ];
        /**@var Staff $staff*/
        $staff = $fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaffAndWaitSessionInstall',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos
            ]
        )->run();
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        $this->assertCheckGUIOnSetClosingBalancePopup->processAssert($this->webposIndex);

        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
    }

    /**
     *
     */
    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no']
        )->run();
    }
}