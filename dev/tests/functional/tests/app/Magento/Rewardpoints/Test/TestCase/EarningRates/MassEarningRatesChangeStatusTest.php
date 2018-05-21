<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/22/2017
 * Time: 2:30 PM
 */

namespace Magento\Rewardpoints\Test\TestCase\EarningRates;

use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

/**
 * Preconditions:
 * 1. Create earning rates according to data set.
 *
 * Steps:
 * 1. LoginTest to backend.
 * 2. Navigate Reward points > Earning Rates
 * 3. Select earning rates created in preconditions.
 * 4. Select Change status action from mass-action.
 * 5. Select Inactive
 * 6. Perform asserts.
 *
 */
class MassEarningRatesChangeStatusTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    /* end tags */

    private $earningRatesIndex;

    private $changeStatusEarningRates = 'Change status';

    private $fixtureFactory;

    public function __inject(
        EarningRatesIndex $earningRatesIndex,
        FixtureFactory $fixtureFactory
    ) {
        $this->earningRatesIndex = $earningRatesIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function test(
        $gridStatus,
        array $initialEarningRates,
        FixtureFactory $fixtureFactory
    ) {
        // Preconditions
        $changeStatusEarningRates = [];
        foreach ($initialEarningRates as $earningRates) {
            list($fixture, $dataset) = explode('::', $earningRates);
            $earningRates = $fixtureFactory->createByCode($fixture, ['dataset' => $dataset]);
            $earningRates->persist();
            $changeStatusEarningRates[] = ['rate_id' => $earningRates->getRateId()];
        }

        // Steps
        $this->earningRatesIndex->open();
        $this->earningRatesIndex->getEarningRatesGrid()
            ->massaction($changeStatusEarningRates, [$this->changeStatusEarningRates => $gridStatus]);
        return $changeStatusEarningRates;
    }
}
