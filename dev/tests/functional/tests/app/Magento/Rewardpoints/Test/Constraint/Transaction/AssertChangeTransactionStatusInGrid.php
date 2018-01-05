<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/22/2017
 * Time: 3:57 PM
 */

namespace Magento\Rewardpoints\Test\Constraint\Transaction;

use Magento\Rewardpoints\Test\Page\Adminhtml\TransactionIndex;
use Magento\Rewardpoints\Test\Fixture\Transaction;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertChangeTransactionStatusInGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param Transaction $transactions
     * @param TransactionIndex $transactionsIndex
     * @return void
     */
    public function processAssert(
        Transaction $transactions,
        TransactionIndex $transactionsIndex
    ) {
        $transactionsIndex->open();
        $transactionsStatus = ($transactions->getStatus() === null || $transactions->getStatus() === 'Yes')
            ? 'Complete'
            : 'Canceled';
        $filter = ['status' => $transactionsStatus];
        \PHPUnit_Framework_Assert::assertTrue(
            $transactionsIndex->getTransactionGrid()->isRowVisible($filter),
            'Transaction \'' . $transactions->getTransactionId() . '\' is absent in Transactions grid.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Transactions are in grid.';
    }
}