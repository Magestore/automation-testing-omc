<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/13/2018
 * Time: 10:08 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\OpenSession;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Constraint\SessionManagement\AssertConfirmModalPopupNotVisible;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Staff;

/**
 * Class WebposManagementValidate05Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposManagementValidate07Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertConfirmModalPopupNotVisible
     */
    protected $assertConfirmModalPopupNotVisible;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertConfirmModalPopupNotVisible $assertConfirmModalPopupNotVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertConfirmModalPopupNotVisible $assertConfirmModalPopupNotVisible
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertConfirmModalPopupNotVisible = $assertConfirmModalPopupNotVisible;
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
        $staffData['location_id'] = [$locationId];
        $staffData['pos_ids'] = [$posId];
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
        $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue(2);
        $this->webposIndex->getOpenSessionPopup()->getIconAddNew()->click();

        $this->assertTrue(
            count($this->webposIndex->getOpenSessionPopup()->getIconDeletes()) > 1,
            'Add row action does not work'
        );

        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        /** wait request done */
        while ( !$this->webposIndex->getListShift()->getFirstItemShift()->isVisible()) {
            sleep(1);
        }

        $this->assertTrue(
            strpos(
                $this->webposIndex->getSessionInfo()->getOpeningBalance()->getText(),
                ($denomination->getDenominationValue() * 2).''
            ) !== false,
            'Subtotal is not equal opening balance'. $this->webposIndex->getSessionInfo()->getOpeningBalance()->getText().
            ($denomination->getDenominationValue() * 2).''
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

