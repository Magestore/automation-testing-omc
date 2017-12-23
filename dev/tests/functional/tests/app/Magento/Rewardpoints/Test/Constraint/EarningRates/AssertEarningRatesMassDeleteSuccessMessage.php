<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/22/2017
 * Time: 9:22 AM
 */

namespace Magento\Rewardpoints\Test\Constraint\EarningRates;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;

class AssertEarningRatesMassDeleteSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after deletion via mass actions
     */
    const SUCCESS_DELETE_MESSAGE = 'A total of %d record(s) were deleted.';


    public function processAssert($initialEarningRates, EarningRatesIndex $earningRatesIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_DELETE_MESSAGE, count($initialEarningRates)),
            $earningRatesIndex->getMessagesBlock()->getSuccessMessage(),
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
        return 'Mass delete earning rates message is displayed.';
    }
}