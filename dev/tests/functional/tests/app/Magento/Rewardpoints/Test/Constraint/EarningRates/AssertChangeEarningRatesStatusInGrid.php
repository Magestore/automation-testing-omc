<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/22/2017
 * Time: 2:45 PM
 */

namespace Magento\Rewardpoints\Test\Constraint\EarningRates;

use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;
use Magento\Rewardpoints\Test\Fixture\EarningRates;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertChangeEarningRatesStatusInGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param EarningRates $earningRates
     * @param EarningRatesIndex $earningRatesIndex
     * @return void
     */
    public function processAssert(
        EarningRates $earningRates,
        EarningRatesIndex $earningRatesIndex
    ) {
        $earningRatesIndex->open();
        $earningRatesStatus = ($earningRates->getStatus() === null || $earningRates->getStatus() === 'Yes')
            ? 'Active'
            : 'Inactive';
        $filter = ['status' => $earningRatesStatus];
        \PHPUnit_Framework_Assert::assertTrue(
            $earningRatesIndex->getEarningRatesGrid()->isRowVisible($filter),
            'EarningRate \'' . $earningRates->getRateId() . '\' is absent in Earning Rates grid.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Earning Rates are in grid.';
    }
}
