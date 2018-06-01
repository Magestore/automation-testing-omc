<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 08/12/2017
 * Time: 16:01
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCreateMultiOrderAndThenLogInBySameStaffCP28Test
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\CategoryRepository\MultiOrder
 *
 * Precondition:
 * "In backend:
 * 1. Setting [Need to create session before working] = Yes
 * In webpos:
 * 1. Login webpos as a staff
 * 2.  Create multi order
 * 3. Close session
 * 4. Logout webpos"
 *
 * Steps:
 * "1. Login webpos by the same staff
 * 2. Create new session
 * 3. Go to cart page"
 *
 * Acceptance:
 * Don't show multi order which created on step 2 of [Precondition and setup steps] column
 *
 */
class WebposCreateMultiOrderAndThenLogInBySameStaffCP28Test extends Injectable
{
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;
    protected $dataConfigToNo;
    protected $configuration;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @return void
     */
    public function __inject(
        DataInterface $configuration,
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
        $this->configuration = $configuration;
    }

    /**
     * LoginTest AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @param ConfigData $dataConfigToNo
     * @return void
     */
    public function test(ConfigData $dataConfigToNo)
    {
        $this->dataConfigToNo = $dataConfigToNo;
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_session_before_working']
        )->run();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        // Open session
        $time = time();
        $timeAfter = $time + 5;
        while (!$this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->isVisible()
            && $time < $timeAfter) {
            $time = time();
        }
        if ($this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->isVisible()) {
            if ($this->webposIndex->getOpenSessionPopup()->getLoadingElement()->isVisible()) {
                $this->webposIndex->getOpenSessionPopup()->waitForElementNotVisible('.indicator[data-bind="visible:loading"]');
            }
            $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-open-shift"]');
            sleep(2);
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->checkout();
            sleep(2);
        }
        $this->webposIndex->getCheckoutCartFooter()->waitButtonHoldVisible();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(1);
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(3);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCMenu()->getSessionManagement();
        sleep(1);
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        sleep(1);
        $this->webposIndex->getSessionCloseShift()->getConfirmSession()->click();
        sleep(1);
        if ($this->webposIndex->getModal()->isVisible()) {
            $this->webposIndex->getModal()->getOkButton()->click();
            sleep(1);
            $this->webposIndex->getSessionSetClosingBalanceReason()->getButtonBtnDone()->click();
            sleep(1);
        }
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCMenu()->logout();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();

        //LoginTest webpos by the same staff
        $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        for ($i = 1; $i <= 2; $i++) {
            self::assertFalse(
                $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($i)->isVisible(),
                'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass, the cart order item was visible successfully.'
            );
        }
    }

    public function tearDown()
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'setup_session_before_working_to_no']
        )->run();
    }
}