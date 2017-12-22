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
