<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/8/2017
 * Time: 8:22 AM
 */

namespace Magento\Rewardpoints\Test\Constraint\EarningRates;

use Magento\Rewardpoints\Test\Fixture\EarningRates;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertEarningRatesInGrid
 * @package Magento\Rewardpoints\Test\Constraint\EarningRates
 */
class AssertEarningRatesInGrid extends AbstractConstraint
{


    /**
     * @param EarningRates $earningRates
     * @param EarningRatesIndex $earningRatesIndex
     */
    public function processAssert(EarningRates $earningRates, EarningRatesIndex $earningRatesIndex)
    {
        $earningRatesIndex->open();
        $filter = [
//            'rate_id[from]' => $rate->getRateId(),
            'points[from]' => $earningRates->getData('points'),
            'points[to]' => $earningRates->getData('points'),
//            'money[from]' => $rate->getData('money'),
//            'money[to]' => $rate->getData('money'),
//            'sort_order[from]' => $rate->getSortOrder(),
        ];
        $errorMessage = implode(', ', $filter);
        $earningRatesIndex->getEarningRatesGrid()->search($filter);

        \PHPUnit_Framework_Assert::assertTrue(
            $earningRatesIndex->getEarningRatesGrid()->isRowVisible($filter, false, false),
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