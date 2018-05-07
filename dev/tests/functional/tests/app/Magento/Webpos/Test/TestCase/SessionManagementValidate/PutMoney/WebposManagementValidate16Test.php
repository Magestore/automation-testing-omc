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
use Magento\Webpos\Test\Fixture\Denomination;

class WebposManagementValidate16Test extends Injectable
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
     * @param Denomination $denomination
     * @param Pos $pos
     * @param FixtureFactory $fixtureFactory
     * @param float $des
     */
    public function test(
        Denomination $denomination,
        Pos $pos,
        FixtureFactory $fixtureFactory,
        $des
    ) {
        // Precondition
        $denomination->persist();

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
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
                'hasOpenSession' => false
            ]
        )->run();

        $beforeOpeningBalance  =  $this->webposIndex->getSessionInfo()->getOpeningBalance()->getText();
        $this->webposIndex->getOpenSessionPopup()->setCoinBillValue($denomination->getDenominationName());
        $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue(10);
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        $openAmount = $denomination->getDenominationValue() * 10;

        /** wait request done */
        while ( $beforeOpeningBalance ==  $this->webposIndex->getSessionInfo()->getOpeningBalance()->getText()) {}

        $this->assertTrue(
            strpos(
                $this->webposIndex->getSessionInfo()->getOpeningBalance()->getText(),
                $openAmount.''
            ) !== false,
            'Subtotal is not equal opening balance'. $this->webposIndex->getSessionInfo()->getOpeningBalance()->getText().
            $openAmount.''
        );

        $this->webposIndex->getSessionShift()->getPutMoneyInButton()->click();
        sleep(1);
        $reasonText = 'Test reason';
        $this->webposIndex->getSessionMakeAdjustmentPopup()->getAmount()->setValue($des);
        $this->webposIndex->getSessionMakeAdjustmentPopup()->getReason()->setValue($reasonText);
        $this->webposIndex->getSessionMakeAdjustmentPopup()->getDoneButton()->click();
        sleep(1);
        $this->assertTrue(
            !$this->webposIndex->getSessionMakeAdjustmentPopup()->isVisible(),
            'Put Money In popup is not hidden'
        );
        $this->assertTrue(
            strpos(
                $this->webposIndex->getSessionInfo()->getDifferenceAmount()->getText(),
                ''.($des + $openAmount)
            ) !== false,
            'Difference amount must be -'.($des + $openAmount)
        );
        $this->assertTrue(
            strpos(
                $this->webposIndex->getSessionInfo()->getTheoreticalClosingBalance()->getText(),
                ($des + $openAmount) . ''
            ) !== false,
            'Theoretical Closing Balance amount must be '.($des + $openAmount)
        );

        $this->assertTrue(
            strpos(
                $this->webposIndex->getSessionInfo()->getAddTransactionTotal()->getText(),
                $des. ''
            ) !== false,
            'Add Transaction amount must be '.$des
        );

        $this->webposIndex->getSessionShift()->getAddTransition()->click();
        sleep(1);

        /**
         * @var \Magento\Mtf\Client\ElementInterface $transaction
         */
        $hasTransaction = false;
        foreach ($this->webposIndex->getCashActivitiesPopup()->getTransactionsWithNote() as $transaction) {
            if ($transaction->getText() === $reasonText) {
                $hasTransaction = true;
                break;
            }
        }

        $this->assertTrue(
            $hasTransaction,
            'Put Money In transaction is not record'
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

