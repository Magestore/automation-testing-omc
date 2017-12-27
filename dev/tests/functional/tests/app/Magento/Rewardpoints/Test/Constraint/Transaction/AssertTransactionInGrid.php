<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/15/2017
 * Time: 1:53 PM
 */

namespace Magento\Rewardpoints\Test\Constraint\Transaction;

use Magento\Rewardpoints\Test\Fixture\Transaction;
use Magento\Rewardpoints\Test\Page\Adminhtml\TransactionIndex;
use Magento\Mtf\Constraint\AbstractConstraint;


class AssertTransactionInGrid extends AbstractConstraint
{

    public function processAssert(Transaction $transaction, TransactionIndex $transactionIndex)
    {
        $transactionIndex->open();
        $filter = [
//            'transaction_id[from]' => $transaction->getData('transaction_id'),
//            'transaction_id[to]' => $transaction->getData('transaction_id'),
            'point_amount[from]' => $transaction->getData('point_amount'),
            'point_amount[to]' => $transaction->getData('point_amount'),
            'title' => $transaction->getData('title'),
//            'customer_email' => $transaction->getData('customer_email'),

        ];
        $errorMessage = implode(', ', $filter);
        $transactionIndex->getTransactionGrid()->search($filter);

        \PHPUnit_Framework_Assert::assertTrue(
            $transactionIndex->getTransactionGrid()->isRowVisible($filter, false, false),
            'Transaction with '
            . $errorMessage
            . 'is absent in Transaction grid.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Transaction is present in grid.';
    }
}