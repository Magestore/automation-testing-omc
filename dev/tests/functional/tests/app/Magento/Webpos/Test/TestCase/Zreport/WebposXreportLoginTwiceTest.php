<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 10/05/2018
 * Time: 14:13
 */

namespace Magento\Webpos\Test\TestCase\Zreport;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposXreportLoginTwiceTest
 *
 * Precondition: There are some POS and setting [Need to create session before working] = "Yes" on the test site
 * 1. Login webpos by a staff (ex: Staff A)
 * 2. Open a session
 * 3. Create some orders successfully
 * 4. Logout
 * 5. Login webpos by another staff (ex: Staff B)
 *
 * Steps:
 * 1. Go to [Session Management] menu
 * 2. Click to print X-report
 *
 * Acceptance:
 * 2. [Staff] field will show name of the current staff (Staff B)
 *
 * @package Magento\Webpos\Test\TestCase\Zreport
 */
class WebposXreportLoginTwiceTest extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(
        $products,
        Pos $pos,
        FixtureFactory $fixtureFactory
    )
    {
        // Create denomination
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_session_before_working']
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
        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
                'hasOpenSession' => false,
                'hasWaitOpenSessionPopup' => false
            ]
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $staffName1 = $staff->getDisplayName();
        $this->webposIndex->getCMenu()->logout();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('.modals-wrapper');
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('#checkout-loader.loading-mask');

        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
        $staffData = $staff->getData();
        $staffData['location_id'] = [$locationId];
        $staffData['pos_ids'] = [$posId];
        /**@var Staff $staff */
        $staff = $fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
                'hasOpenSession' => false,
                'hasWaitOpenSessionPopup' => false
            ]
        )->run();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $staffName2 = $staff->getDisplayName();
        $this->webposIndex->getCMenu()->getSessionManagement();
        sleep(1);

        $openedString = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $openedString .= ' by ' . $staffName1;

        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitReportPopupVisible();
        return [
            'staffName' => $staffName2,
            'openedString' => $openedString
        ];
    }

    public function tearDown()
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'setup_session_before_working_to_no']
        )->run();
    }
}