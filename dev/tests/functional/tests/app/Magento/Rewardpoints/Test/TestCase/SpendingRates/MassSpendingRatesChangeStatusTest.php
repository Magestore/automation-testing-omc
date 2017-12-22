<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/22/2017
 * Time: 3:32 PM
 */

namespace Magento\Rewardpoints\Test\TestCase\SpendingRates;

use Magento\Rewardpoints\Test\Page\Adminhtml\SpendingRatesIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

class MassSpendingRatesChangeStatusTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    /* end tags */

    private $spendingRatesIndex;

    private $changeStatusSpendingRates = 'Change status';

    private $fixtureFactory;

    public function __inject(
        SpendingRatesIndex $spendingRatesIndex,
        FixtureFactory $fixtureFactory
    ) {
        $this->spendingRatesIndex = $spendingRatesIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function test(
        $gridStatus,
        array $initialSpendingRates,
        FixtureFactory $fixtureFactory
    ) {
        // Preconditions
        $changeStatusSpendingRates = [];
        foreach ($initialSpendingRates as $spendingRates) {
            list($fixture, $dataset) = explode('::', $spendingRates);
            $spendingRates = $fixtureFactory->createByCode($fixture, ['dataset' => $dataset]);
            $spendingRates->persist();
            $changeStatusSpendingRates[] = ['rate_id' => $spendingRates->getRateId()];
        }

        // Steps
        $this->spendingRatesIndex->open();
        $this->spendingRatesIndex->getSpendingRatesGrid()
            ->massaction($changeStatusSpendingRates, [$this->changeStatusSpendingRates => $gridStatus]);
        return $changeStatusSpendingRates;
    }
}
