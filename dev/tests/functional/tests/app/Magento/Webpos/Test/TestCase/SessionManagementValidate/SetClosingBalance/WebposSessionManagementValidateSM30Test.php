<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/12/2018
 * Time: 1:31 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Constraint\SessionManagement\AssertConfirmModalPopup;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Staff;

/**
 * Class WebposSessionManagementValidateSM30Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposSessionManagementValidateSM30Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertConfirmModalPopup
     */
    protected $assertConfirmModalPopup;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertConfirmModalPopup $assertConfirmModalPopup
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertConfirmModalPopup $assertConfirmModalPopup
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertConfirmModalPopup = $assertConfirmModalPopup;
    }

    /**
     * @param Denomination $denomination
     * @param Pos $pos
     * @param FixtureFactory $fixtureFactory
     */
    public function test(Denomination $denomination, Pos $pos, FixtureFactory $fixtureFactory)
    {
        // Precondition
        $denomination->persist();

        //Config create session before working
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes']
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
                'hasOpenSession' => false
            ]
        )->run();
        $this->webposIndex->getOpenSessionPopup()->waitLoader();
        $this->webposIndex->getOpenSessionPopup()->setCoinBillValue($denomination->getDenominationName());
        $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue(10);

        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        /** wait done open request */
        while (!$this->webposIndex->getListShift()->getFirstItemShift()->isVisible()) {
            sleep(1);
        }
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        $this->webposIndex->getSessionCloseShift()->waitSetClosingBalancePopupVisible();
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        sleep(1);
        $realBalance = $this->webposIndex->getSessionConfirmModalPopup()->getRealBalance();
        $theoryIs = $this->webposIndex->getSessionConfirmModalPopup()->getTheoryIs();
        $loss = $this->webposIndex->getSessionConfirmModalPopup()->getLoss();

        $this->assertConfirmModalPopup->processAssert($this->webposIndex, $realBalance, $theoryIs, $loss);
        $this->webposIndex->getSessionConfirmModalPopup()->getOkButton()->click();
        $this->webposIndex->getSessionSetClosingBalanceReason()->waitSetReasonPopupVisible();
        $this->webposIndex->getSessionSetReasonPopup()->getReason()->setValue('Magento');
        sleep(1);
        $this->webposIndex->getSessionSetReasonPopup()->getConfirmButton()->click();
        $this->webposIndex->getSessionSetClosingBalanceReason()->waitSetReasonPopupNotVisible();
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