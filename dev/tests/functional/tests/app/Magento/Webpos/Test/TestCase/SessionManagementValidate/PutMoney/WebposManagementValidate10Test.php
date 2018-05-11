<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/13/2018
 * Time: 10:08 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\PutMoney;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Location;

class WebposManagementValidate10Test extends Injectable
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
     * @param Pos $pos
     * @param FixtureFactory $fixtureFactory
     */
    public function test(Pos $pos, FixtureFactory $fixtureFactory)
    {

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
        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaffAndWaitSessionInstall',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
            ]
        )->run();

        $this->webposIndex->getSessionShift()->getPutMoneyInButton()->click();
        sleep(1);
        $this->assertTrue(
            $this->webposIndex->getSessionMakeAdjustmentPopup()->isVisible(),
            'Put Money In popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getSessionMakeAdjustmentPopup()->getModalTitle()->getText() === 'Put Money In',
            'Title Put Money In popup is wrong'
        );

        $this->assertTrue(
            $this->webposIndex->getSessionMakeAdjustmentPopup()->getCancelButton()->isVisible(),
            'Cancel button on Put Money In popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getSessionMakeAdjustmentPopup()->getDoneButton()->isVisible(),
            'Done button on Put Money In popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getSessionMakeAdjustmentPopup()->getReason()->isVisible(),
            'Reason textarea on Put Money In popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getSessionMakeAdjustmentPopup()->getAmount()->getText() == 0,
            'Amount on Put Money In popup is wrong'
        );

        $this->assertTrue(
            $this->webposIndex->getSessionMakeAdjustmentPopup()->getStaff()->getText() === $staff->getDisplayName(),
            'Staff on Put Money In popup must be '. $staff->getDisplayName()
            . ' not be '. $this->webposIndex->getSessionMakeAdjustmentPopup()->getStaff()->getText()
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

