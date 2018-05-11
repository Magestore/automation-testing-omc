<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/14/2018
 * Time: 8:01 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Staff;

/**
 * Class WebposSessionManagementValidateSM36Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposSessionManagementValidateSM36Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    ) {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;

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
        $product = $this->fixtureFactory->createByCode('catalogProductSimple', ['dataset' => 'product_100_dollar_taxable']);
        $product->persist();

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
        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaffAndWaitSessionInstall',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
                'hasOpenSession' => false
            ]
        )->run();

        while ( !$this->webposIndex->getOpenSessionPopup()->getCoinBillValue()->isVisible()) {
            sleep(1);
        }

        $this->webposIndex->getOpenSessionPopup()->setCoinBillValue($denomination->getDenominationName());
        /** now balance is 100 */
        $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue(10);
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();

        /** wait done open request */
        while ( !$this->webposIndex->getListShift()->getFirstItemShift()->isVisible()) {
            sleep(1);
        }

        // Order
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->checkout();
        sleep(2);
        $this->webposIndex->getCheckoutCartFooter()->waitButtonHoldVisible();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        /** product price 100 */
        $this->webposIndex->getCheckoutProductList()->search($product->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        /** now balance is 200 */
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->getSessionManagement();

        /** wait list request */
        while ( !$this->webposIndex->getListShift()->getFirstItemShift()->isVisible()) {
            sleep(1);
        }
        // Put money in

        $this->webposIndex->getSessionShift()->getPutMoneyInButton()->click();
        sleep(1);
        /** now balance is 200, put in 500 */
        $this->webposIndex->getSessionMakeAdjustmentPopup()->getAmount()->setValue(1);
        $this->webposIndex->getSessionMakeAdjustmentPopup()->getDoneButton()->click();
        $differenceAmountBeforePutIn = $this->webposIndex->getSessionShift()->getTransactionsInfo('Difference')->getText();
        while ($differenceAmountBeforePutIn == $this->webposIndex->getSessionShift()->getTransactionsInfo('Difference')->getText()) {
            sleep(1);
        }
        $this->webposIndex->getSessionShift()->getTakeMoneyOutButton()->click();
        sleep(1);
        /** now balance is 200, put out 200 */
        $this->webposIndex->getSessionMakeAdjustmentPopup()->getAmount()->setValue(1);
        $this->webposIndex->getSessionMakeAdjustmentPopup()->getDoneButton()->click();
        $differenceAmountBeforePutOut = $this->webposIndex->getSessionShift()->getTransactionsInfo('Difference')->getText();
        while ($differenceAmountBeforePutOut == $this->webposIndex->getSessionShift()->getTransactionsInfo('Difference')->getText()) {
            sleep(1);
        }

        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        sleep(1);
        $this->webposIndex->getOpenSessionPopup()->waitForElementNotVisible('[data-bind="visible:loading"]');

        $this->webposIndex->getSessionSetClosingBalancePopup()->getNumberOfCoinsBills()->setValue(20);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        sleep(5);
        // Assert Set Closing Balance Popup not visible
        $this->assertFalse(
            $this->webposIndex->getSessionSetClosingBalancePopup()->isVisible(),
            'Set Closing Balance Popup is visible.'
        );

        // Assert [End of session] button changes into [Validate Closing] button
        $this->assertEquals(
            'Validate Closing',
            $this->webposIndex->getSessionShift()->getButtonEndSession()->getText(),
            'Button "Validate Closing" is not visible.'
        );


        // Assert Difference = 0
        $difference = $this->webposIndex->getSessionShift()->getTransactionsInfo('Difference')->getText();
        $difference = substr($difference, 2);
        $this->assertEquals(
            '0',
            $difference,
            'Difference is not correct. '. $difference
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