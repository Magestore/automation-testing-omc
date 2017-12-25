<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/25/2017
 * Time: 8:35 AM
 */

namespace Magento\Rewardpoints\Test\Constraint\SpendingRates;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\SpendingRatesIndex;

class AssertSpendingRatesMassDeleteSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after deletion via mass actions
     */
    const SUCCESS_DELETE_MESSAGE = 'A total of %d record(s) were deleted.';


    public function processAssert($initialSpendingRates, SpendingRatesIndex $spendingRatesIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_DELETE_MESSAGE, count($initialSpendingRates)),
            $spendingRatesIndex->getMessagesBlock()->getSuccessMessage(),
            'Wrong delete message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Mass delete spending rates message is displayed.';
    }
}