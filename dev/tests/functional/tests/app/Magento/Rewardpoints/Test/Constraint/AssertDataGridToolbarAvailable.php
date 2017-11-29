<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 8:41 AM
 */

namespace Magento\Rewardpoints\Test\Constraint;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;

class AssertDataGridToolbarAvailable extends AbstractConstraint
{

    public function processAssert(EarningRatesIndex $earningRatesIndex, $search = false, $actionButton = true)
    {
        $earningRatesIndex->getEarningRatesGrid()->waitingForGridVisible();
        if ($search !== false) {
            \PHPUnit_Framework_Assert::assertTrue(
                $earningRatesIndex->getEarningRatesGrid()->dataGridSearchIsVisible(),
                'Data grid search is not visible.'
            );
        }
        if ($actionButton == true) {
            \PHPUnit_Framework_Assert::assertTrue(
                $earningRatesIndex->getEarningRatesGrid()->actionButtonIsVisible(),
                'Action button is not visible.'
            );
        }
        \PHPUnit_Framework_Assert::assertTrue(
            $earningRatesIndex->getEarningRatesGrid()->filtersButtonIsVisible(),
            'Filters button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $earningRatesIndex->getEarningRatesGrid()->dataGridActionIsVisible(),
            'Data grid action is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $earningRatesIndex->getEarningRatesGrid()->dataGridPagerIsVisible(),
            'Data grid pager is not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Data grid toolbar is available.';
    }
}