<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/13/2018
 * Time: 10:08 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\OpenSession;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Denomination;

class WebposManagementValidate09Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    private $webposIndex;

    /**
     * Inject WebposIndex pages.
     *
     * @param $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    ) {
        $this->webposIndex = $webposIndex;
    }

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes_MS57']
        )->run();
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
        $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue(10);
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        /** wait request done */
        while ( !$this->webposIndex->getListShift()->getFirstItemShift()->isVisible()) {
            sleep(1);
        }
        $this->assertTrue(
            strpos(
                $this->webposIndex->getSessionInfo()->getOpeningBalance()->getText(),
                ($denomination->getDenominationValue() * 10).''
            ) !== false,
            'Subtotal is not equal opening balance'
            . $this->webposIndex->getSessionInfo()->getOpeningBalance()->getText()
            . '!='.
            ($denomination->getDenominationValue() * 10).''
        );
        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        sleep(1);
        $this->webposIndex->getCMenu()->logout();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('.modals-wrapper');
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('#checkout-loader.loading-mask');
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
        $staffData = $staff->getData();
        $staffData['location_id'] = [$locationId];
        $staffData['pos_ids'] = [$posId];
        /**@var Staff $staff*/
        $staff = $fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
                'hasOpenSession' => false,
                'hasWaitOpenSessionPopup' => false,
            ]
        )->run();

        $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
        $this->webposIndex->getCMenu()->getSessionManagement();

        while ( !$this->webposIndex->getListShift()->getFirstItemShift()->isVisible()) {
            sleep(1);
        }

        $this->assertTrue(
            strpos(
                $this->webposIndex->getSessionInfo()->getOpeningBalance()->getText(),
                ($denomination->getDenominationValue() * 10).''
            ) !== false,
            'Subtotal is not equal opening balance'
            . $this->webposIndex->getSessionInfo()->getOpeningBalance()->getText()
            . '!='.
            ($denomination->getDenominationValue() * 10).''
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

