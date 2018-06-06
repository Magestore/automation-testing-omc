<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/8/2018
 * Time: 1:55 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Location;

class WebposManagementValidate02Test extends Injectable
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

    protected $configuration;
    /**
     * @var
     */
    protected $fixtureFactory;

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
        $posData['location_id'] = [$locationId];
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

        $this->assertTrue(
            $this->webposIndex->getOpenSessionPopup()->isVisible(),
            'open session popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getOpenSessionPopup()->getStaff()->isVisible(),
            'Field staff on open session popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getOpenSessionPopup()->getPOS()->isVisible(),
            'Field POS on open session popup is not show'
        );


        $this->assertTrue(
            $this->webposIndex->getOpenSessionPopup()->getOpeningBalance()->isVisible(),
            'Field Opening Balance on open session popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getOpenSessionPopup()->getCoinBillValueColumn()->isVisible(),
            'column Coin / Bill Value on open session popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinBillValueColumn()->isVisible(),
            'column Number of Coin / Bill on open session popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getOpenSessionPopup()->getSubtotalColumn()->isVisible(),
            'column Subtotal on open session popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getOpenSessionPopup()->getIconDeleteFirst()->isVisible(),
            'Delete action on open session popup is not show'
        );

        $this->assertTrue(
            $this->webposIndex->getOpenSessionPopup()->getIconAddNew()->isVisible(),
            'Add new row action on open session popup is not show'
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

