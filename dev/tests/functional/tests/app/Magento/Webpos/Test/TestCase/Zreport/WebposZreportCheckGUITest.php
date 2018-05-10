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
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposZreportCheckGUITest
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

    public function test($products, Denomination $denomination,
                         $denominationNumberCoin, ConfigData $dataConfig, ConfigData $dataConfigToNo)
    {
        // Create denomination
//        $denomination->persist();
//        $this->dataConfigToNo = $dataConfigToNo;
//        $this->objectManager->create(
//            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
//            ['dataConfig' => $dataConfig]
//        )->run();

        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->getSessionManagement();
        sleep(1);
        // Set closing balance
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        sleep(1);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getColumnNumberOfCoinsAtRow(2)->setValue($denominationNumberCoin);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        sleep(1);
        $this->webposIndex->getSessionConfirmModalPopup()->getOkButton()->click();
        $this->webposIndex->getSessionSetReasonPopup()->getReason()->setValue('Magento');
        sleep(1);
        $this->webposIndex->getSessionSetReasonPopup()->getConfirmButton()->click();
        sleep(1);
        // End session
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        sleep(1);
        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');
        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitZreportVisible();
        sleep(2);
        return ['staff'=> $staff];
    }

    public function tearDown()
    {
//        $this->objectManager->create(
//            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
//            ['dataConfig' => $this->dataConfigToNo]
//        )->run();
    }

}