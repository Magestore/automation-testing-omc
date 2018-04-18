<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/19/2017
 * Time: 9:32 AM
 */

namespace Magento\Rewardpoints\Test\TestCase\EarningRates;

use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;
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
 * 2. Go to Reward points > Earning Rates
 * 3. Select N Earning Rates from preconditions
 * 4. Select in dropdown "Delete"
 * 5. Click Submit button
 * 6. Perform all assertions according to dataset
 *
 */
class MassDeleteEarningRatesEntityTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    /* end tags */

    private $earningRatesIndex;

    private $earningRatesGridAction = 'Delete';

    private $fixtureFactory;

    public function __inject(
        EarningRatesIndex $earningRatesIndex,
        FixtureFactory $fixtureFactory
    ) {
        $this->earningRatesIndex = $earningRatesIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->earningRatesIndex->open();
        $this->earningRatesIndex->getEarningRatesGrid()->massaction([], 'Delete', true, 'Select All');
    }

    public function test(
        array $initialEarningRates,
        FixtureFactory $fixtureFactory
    ) {
        // Preconditions
        $deleteEarningRates = [];
        foreach ($initialEarningRates as $earningRates) {
            list($fixture, $dataset) = explode('::', $earningRates);
            $earningRates = $fixtureFactory->createByCode($fixture, ['dataset' => $dataset]);
            $earningRates->persist();
            $deleteEarningRates[] = ['rate_id' => $earningRates->getRateId()];
        }

        // Steps
        $this->earningRatesIndex->open();
        $this->earningRatesIndex->getEarningRatesGrid()->massaction($deleteEarningRates, 'Delete', true);
        return $deleteEarningRates;
    }
}
