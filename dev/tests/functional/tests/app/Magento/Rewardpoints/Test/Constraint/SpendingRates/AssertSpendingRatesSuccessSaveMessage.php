<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/8/2017
 * Time: 11:09 AM
 */

namespace Magento\Rewardpoints\Test\Constraint\SpendingRates;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\SpendingRatesIndex;


/**
 * Class AssertSpendingRatesSuccessSaveMessage
 * @package Magento\Rewardpoints\Test\Constraint\SpendingRates
 */
class AssertSpendingRatesSuccessSaveMessage extends AbstractConstraint
{

    /**
     *
     */
    const SUCCESS_MESSAGE = 'Spending rate was successfully saved';


    /**
     * @param SpendingRatesIndex $spendingRatesIndex
     */
    public function processAssert(SpendingRatesIndex $spendingRatesIndex)
    {
        $actualMessage = $spendingRatesIndex->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_MESSAGE,
            $actualMessage,
            'Wrong success message is displayed.'
            . "\nExpected: " . self::SUCCESS_MESSAGE
            . "\nActual: " . $actualMessage
        );
    }

    /**
     * Text success save message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'Assert that success message is displayed.';
    }
}