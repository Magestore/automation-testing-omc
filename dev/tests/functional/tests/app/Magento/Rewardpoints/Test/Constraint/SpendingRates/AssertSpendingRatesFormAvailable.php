<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 11/28/2017
 * Time: 8:57 AM
 */
namespace Magento\Rewardpoints\Test\Constraint\SpendingRates;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\SpendingRatesNew;

class AssertSpendingRatesFormAvailable extends AbstractConstraint
{

    public function processAssert(SpendingRatesNew $spendingRatesNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $spendingRatesNew->getSpendingRatesForm()->isVisible(),
            'Spending Rates form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $spendingRatesNew->getSpendingRatesForm()->formTitleIsVisible(),
            'Spending Rates form title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $spendingRatesNew->getSpendingRatesForm()->spendingPointFieldIsVisible(),
            'Spending Point(s) field is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Spending Rates form is available.';
    }
}