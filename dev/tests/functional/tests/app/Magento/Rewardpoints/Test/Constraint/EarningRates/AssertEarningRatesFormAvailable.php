<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 11/28/2017
 * Time: 8:42 AM
 */
namespace Magento\Rewardpoints\Test\Constraint\EarningRates;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesNew;

class AssertEarningRatesFormAvailable extends AbstractConstraint
{

    public function processAssert(EarningRatesNew $earningRatesNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $earningRatesNew->getEarningRatesForm()->isVisible(),
            'Earning Rates form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $earningRatesNew->getEarningRatesForm()->formTitleIsVisible(),
            'Earning Rates form title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $earningRatesNew->getEarningRatesForm()->moneySpentFieldIsVisible(),
            'Money Spent field is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Earning Rates form is available.';
    }
}