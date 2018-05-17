<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 10/05/2018
 * Time: 14:13
 */

namespace Magento\Webpos\Test\TestCase\Zreport;


use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposZreportLoginTwiceTest
 *
 * Precondition: There are some POSs and setting [Need to create session before working] = "Yes" on the test site
 * 1. LoginTest webpos by a staff who has open and close session permission
 * 2. Choose an available POS (ex: POS 1)
 * 3. Open a session
 * 4. Create some orders successfully
 *
 * Steps:
 * 1. Go to [Session Management] menu
 * 2. Close the session successfully
 * 3. Click to print Z-report
 *
 * Acceptance:
 * 3. [POS] field will show name of the current POS (POS 1)
 *
 * @package Magento\Webpos\Test\TestCase\Zreport
 */
class WebposZreportLoginTwiceTest extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;
    protected $dataConfigToNo;


    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(
        $products,
        Denomination $denomination,
        $denominationNumberCoin,
        ConfigData $dataConfig,
        ConfigData $dataConfigToNo,
        Pos $pos,
        FixtureFactory $fixtureFactory)
    {
        // Create denomination
        $denomination->persist();
        $this->dataConfigToNo = $dataConfigToNo;
        $this->objectManager->create(
            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
            ['dataConfig' => $dataConfig]
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

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $staffName1 = $this->webposIndex->getCMenu()->getUsername();
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
        // LoginTest webpos
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
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $staffName2 = $this->webposIndex->getCMenu()->getUsername();
        $this->webposIndex->getCMenu()->getSessionManagement();
        sleep(1);
        // Set closing balance
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        $this->webposIndex->getSessionSetClosingBalancePopup()->getColumnNumberOfCoinsAtRow(2)->setValue($denominationNumberCoin);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        $this->webposIndex->getSessionConfirmModalPopup()->getOkButton()->click();
        $this->webposIndex->getSessionSetReasonPopup()->getReason()->setValue('Magento');
        $this->webposIndex->getSessionSetReasonPopup()->getConfirmButton()->click();
        // End session
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        sleep(1);

        $openedString = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $openedString .= ' by ' . $staffName1;
        $closedString = $this->webposIndex->getSessionShift()->getCloseTime()->getText();
        $closedString .= ' by ' . $staffName2;

        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');
        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitZreportVisible();
        return [
            'staffName' => $staffName2,
            'openedString' => $openedString,
            'closedString' => $closedString
        ];
    }

    public function tearDown()
    {
        $this->objectManager->create(
            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
            ['dataConfig' => $this->dataConfigToNo]
        )->run();
    }
}