<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/15/2018
 * Time: 8:31 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\CheckPrintButton;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Staff;

/**
 * Class WebposSessionManagementValidateSM40Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\CheckPrintButton
 */
class WebposSessionManagementValidateSM40Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    ) {
        $this->webposIndex = $webposIndex;
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
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos
            ]
        )->run();
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        sleep(1);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        sleep(1);
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        sleep(1);
        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');
        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        sleep(1);

        // Assert
        $this->assertTrue(
            $this->webposIndex->getSessionPrintShiftPopup()->isVisible(),
            'X-report is not visible.'
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