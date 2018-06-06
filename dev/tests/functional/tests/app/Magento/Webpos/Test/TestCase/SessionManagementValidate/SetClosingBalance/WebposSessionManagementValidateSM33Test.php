<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/14/2018
 * Time: 8:01 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Constraint\SessionManagement\AssertSetReasonPopup;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Staff;

/**
 * Class WebposSessionManagementValidateSM33Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposSessionManagementValidateSM33Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertSetReasonPopup
     */
    protected $assertSetReasonPopup;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertSetReasonPopup $assertSetReasonPopup
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertSetReasonPopup $assertSetReasonPopup
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertSetReasonPopup = $assertSetReasonPopup;
    }

    /**
     * @param Denomination $denomination
     * @param Pos $pos
     * @param FixtureFactory $fixtureFactory
     */
    public function test( Denomination $denomination, Pos $pos, FixtureFactory $fixtureFactory)
    {
        // Precondition
        $denomination->persist();

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
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
                'hasOpenSession' => false
            ]
        )->run();

        $this->webposIndex->getOpenSessionPopup()->setCoinBillValue($denomination->getDenominationName());
        $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue(10);

        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        /** wait request done  */
        while ( !$this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->isVisible() ) { sleep(1); }
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        sleep(1);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        sleep(1);
        $this->webposIndex->getSessionConfirmModalPopup()->getOkButton()->click();
        sleep(1);

        // Assert Set Reason popup
        $this->assertSetReasonPopup->processAssert($this->webposIndex);

        $this->webposIndex->getSessionSetReasonPopup()->getCancelButton()->click();
        sleep(2);

        // Assert Set Reason popup not visible
        $this->assertFalse(
            $this->webposIndex->getSessionSetReasonPopup()->isVisible(),
            'Set Reason Popup is visible.'
        );

        // Assert [End of session] button changes into [Validate Closing] button
        $this->assertEquals(
            'Validate Closing',
            $this->webposIndex->getSessionShift()->getButtonEndSession()->getText(),
            'Button "Validate Closing" is not visible.'
        );

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