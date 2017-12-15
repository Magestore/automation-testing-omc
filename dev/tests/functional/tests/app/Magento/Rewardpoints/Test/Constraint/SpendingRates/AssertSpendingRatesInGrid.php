<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/8/2017
 * Time: 11:14 AM
 */

namespace Magento\Rewardpoints\Test\Constraint\SpendingRates;

use Magento\Rewardpoints\Test\Fixture\Rate;
use Magento\Rewardpoints\Test\Page\Adminhtml\SpendingRatesIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertSpendingRatesInGrid
 * @package Magento\Rewardpoints\Test\Constraint\SpendingRates
 */
class AssertSpendingRatesInGrid extends AbstractConstraint
{

    /**
     * @param Rate $rate
     * @param SpendingRatesIndex $spendingRatesIndex
     */
    public function processAssert(Rate $rate, SpendingRatesIndex $spendingRatesIndex)
    {
        $spendingRatesIndex->open();
        $filter = [
            'points[from]' => $rate->getData('points'),
            'points[to]' => $rate->getData('points'),
//            'money[from]' => $rate->getData('money'),
//            'money[to]' => $rate->getData('money'),
        ];
        $errorMessage = implode(', ', $filter);
        $spendingRatesIndex->getSpendingRatesGrid()->search($filter);

        \PHPUnit_Framework_Assert::assertTrue(
            $spendingRatesIndex->getSpendingRatesGrid()->isRowVisible($filter, false, false),
            'Earning Rates with '
            . $errorMessage
            . 'is absent in Earning Rates grid.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Earning Rates is present in grid.';
    }
}