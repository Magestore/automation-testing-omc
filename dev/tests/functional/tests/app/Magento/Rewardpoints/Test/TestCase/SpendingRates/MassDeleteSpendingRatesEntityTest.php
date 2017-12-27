<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/19/2017
 * Time: 9:32 AM
 */

namespace Magento\Rewardpoints\Test\TestCase\SpendingRates;

use Magento\Rewardpoints\Test\Page\Adminhtml\SpendingRatesIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

/**
 *
 * Test Flow:
 * Preconditions:
 * 1. Create X Earning Rates
 *
 * Steps:
 * 1. Open backend
 * 2. Go to Reward points > Spending Rates
 * 3. Select N Spending Rates from preconditions
 * 4. Select in dropdown "Delete"
 * 5. Click Submit button
 * 6. Perform all assertions according to dataset
 *
 */
class MassDeleteSpendingRatesEntityTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    /* end tags */

    private $spendingRatesIndex;

    private $spendingRatesGridAction = 'Delete';

    private $fixtureFactory;

    public function __inject(
        SpendingRatesIndex $spendingRatesIndex,
        FixtureFactory $fixtureFactory
    ) {
        $this->spendingRatesIndex = $spendingRatesIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->spendingRatesIndex->open();
        $this->spendingRatesIndex->getSpendingRatesGrid()->massaction([], 'Delete', true, 'Select All');
    }

    public function test(
        array $initialSpendingRates,
        FixtureFactory $fixtureFactory
    ) {
        // Preconditions
        $deleteSpendingRates = [];
        foreach ($initialSpendingRates as $spendingRates) {
            list($fixture, $dataset) = explode('::', $spendingRates);
            $spendingRates = $fixtureFactory->createByCode($fixture, ['dataset' => $dataset]);
            $spendingRates->persist();
            $deleteSpendingRates[] = ['rate_id' => $spendingRates->getRateId()];
        }

        // Steps
        $this->spendingRatesIndex->open();
        $this->spendingRatesIndex->getSpendingRatesGrid()->massaction($deleteSpendingRates, 'Delete', true);
        return $deleteSpendingRates;
    }
}
