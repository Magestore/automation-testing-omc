<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/22/2017
 * Time: 3:35 PM
 */

namespace Magento\Rewardpoints\Test\Constraint\SpendingRates;

use Magento\Rewardpoints\Test\Page\Adminhtml\SpendingRatesIndex;
use Magento\Rewardpoints\Test\Fixture\SpendingRates;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertChangeSpendingRatesStatusInGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param SpendingRates $spendingRates
     * @param SpendingRatesIndex $spendingRatesIndex
     * @return void
     */
    public function processAssert(
        SpendingRates $spendingRates,
        SpendingRatesIndex $spendingRatesIndex
    ) {
        $spendingRatesIndex->open();
        $spendingRatesStatus = ($spendingRates->getStatus() === null || $spendingRates->getStatus() === 'Yes')
            ? 'Active'
            : 'Inactive';
        $filter = ['status' => $spendingRatesStatus];
        \PHPUnit_Framework_Assert::assertTrue(
            $spendingRatesIndex->getSpendingRatesGrid()->isRowVisible($filter),
            'SpendingRate \'' . $spendingRates->getRateId() . '\' is absent in Spending Rates grid.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Spending Rates are in grid.';
    }
}