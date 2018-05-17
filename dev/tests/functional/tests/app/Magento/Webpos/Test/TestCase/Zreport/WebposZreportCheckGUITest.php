<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 13:30
 */

namespace Magento\Webpos\Test\TestCase\Zreport;

use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposZreportCheckGUITest
 *
 * Precondition: There are some POSs and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff who has open and close session permission
 * 2. Open a session
 * 3. Create some orders successfully"
 *
 * Steps:
 * 1. Go to [Session Management] menu
 * 2. Click on [End of Session] > Input real money > [Confirm] > Close session successfully
 * 3. Click on [Print] button
 *
 * Acceptance:
 *
 * @package Magento\Webpos\Test\TestCase\Zreport
 */
class WebposZreportCheckGUITest extends Injectable
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
        ConfigData $dataConfigToNo
    ) {
        // Create denomination
        $denomination->persist();
        $this->dataConfigToNo = $dataConfigToNo;
        $this->objectManager->create(
            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
            ['dataConfig' => $dataConfig]
        )->run();

        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposSetClosingBalanceCloseSessionStep',
            [
                'denomination' => $denomination,
                'denominationNumberCoin' => $denominationNumberCoin
            ]
        )->run();

        $staffName = $this->webposIndex->getSessionShift()->getStaffName()->getText();
        $openedString = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $openedString .= ' by ' . $staffName;
        $closedString = $this->webposIndex->getSessionShift()->getCloseTime()->getText();
        $closedString .= ' by ' . $staffName;

        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitZreportVisible();
        return [
            'staffName' => $staffName,
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