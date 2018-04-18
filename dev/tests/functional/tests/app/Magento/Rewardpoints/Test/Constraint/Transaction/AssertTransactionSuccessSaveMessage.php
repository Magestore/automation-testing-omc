<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/15/2017
 * Time: 1:46 PM
 */

namespace Magento\Rewardpoints\Test\Constraint\Transaction;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\TransactionIndex;


/**
 * Class AssertTransactionSuccessSaveMessage
 * @package Magento\Rewardpoints\Test\Constraint\Transaction
 */
class AssertTransactionSuccessSaveMessage extends AbstractConstraint
{

    /**
     *
     */
    const SUCCESS_MESSAGE = 'Transaction has been created successfully.';


    /**
     * @param TransactionIndex $transactionIndex
     */
    public function processAssert(TransactionIndex $transactionIndex)
    {
        $actualMessage = $transactionIndex->getMessagesBlock()->getSuccessMessage();
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