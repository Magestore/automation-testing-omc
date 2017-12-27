<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/6/2017
 * Time: 4:10 PM
 */

namespace Magento\Rewardpoints\Test\Constraint\EarningRates;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;

/**
 * Class AssertEarningRatesSuccessSaveMessage
 * @package Magento\Rewardpoints\Test\Constraint\EarningRates
 */
class AssertEarningRatesSuccessSaveMessage extends AbstractConstraint
{
    /**
     *
     */
    const SUCCESS_MESSAGE = 'Earning rate was successfully saved';

    /**
     * @param EarningRatesIndex $earningRatesIndex
     */
    public function processAssert(EarningRatesIndex $earningRatesIndex)
    {
        $actualMessage = $earningRatesIndex->getMessagesBlock()->getSuccessMessage();
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