<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 08/12/2017
 * Time: 16:01
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Config\Test\Fixture\ConfigData;
/**
 * Class WebposCreateMultiOrderAndThenLogInByOtherStaffCP28Test
 * @package Magento\Webpos\Test\TestCase\Checkout\MultiOrder
 */
class WebposCreateMultiOrderAndThenLogInByOtherStaffCP28Test extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Login Webpos group test.
     *
     * @param Staff $staff
     * @param Staff ConfigData
     * @return void
     */
    public function test(Staff $staff, ConfigData $dataConfig, ConfigData $dataConfigToNo)
    {
        $this->objectManager->create(
            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
            ['dataConfig' => $dataConfig]
        )->run();
        $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep',
            ['staff' => $staff]
        )->run();
        $this->webposIndex->getLoginForm()->selectLocation('Store Address')->click();
        $this->webposIndex->getLoginForm()->selectPos('Store POS')->click();
        $this->webposIndex->getLoginForm()->getEnterToPos()->click();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCMenu()->getSessionManagement();
        sleep(1);
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        sleep(1);
        $this->webposIndex->getSessionCloseShift()->getConfirmSession()->click();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);
        $this->webposIndex->getSessionSetClosingBalanceReason()->getButtonBtnDone()->click();
        sleep(1);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCMenu()->logout();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();
        //Login webpos by the same staff
        $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep',
            ['staff' => $staff]
        )->run();
        $this->webposIndex->getLoginForm()->selectLocation('Store Address')->click();
        sleep(1);
        $this->webposIndex->getLoginForm()->selectPos('Store POS')->click();
        $this->webposIndex->getLoginForm()->getEnterToPos()->click();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);
        for ($i=1; $i<=2; $i++) {
            self::assertFalse(
                $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($i)->isVisible(),
                'On the Webpos Cart, the cart order item was visible successfully.'
            );
        }
        $this->objectManager->create(
            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
            ['dataConfig' => $dataConfigToNo]
        )->run();
    }
}