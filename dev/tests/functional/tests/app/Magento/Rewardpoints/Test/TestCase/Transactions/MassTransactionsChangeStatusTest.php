<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/22/2017
 * Time: 3:51 PM
 */

namespace Magento\Rewardpoints\Test\TestCase\Transactions;

use Magento\Rewardpoints\Test\Page\Adminhtml\TransactionIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

class MassTransactionsChangeStatusTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    /* end tags */

    private $transactionIndex;

    private $changeStatusTransactions = 'Change status';

    private $fixtureFactory;

    public function __inject(
        TransactionIndex $transactionIndex,
        FixtureFactory $fixtureFactory
    ) {
        $this->transactionIndex = $transactionIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function test(
        $gridStatus,
        array $initialTransactions,
        FixtureFactory $fixtureFactory
    ) {
        // Preconditions
        $changeStatusTransactions = [];
        foreach ($initialTransactions as $transactions) {
            list($fixture, $dataset) = explode('::', $transactions);
            $transactions = $fixtureFactory->createByCode($fixture, ['dataset' => $dataset]);
            $transactions->persist();
            $changeStatusTransactions[] = ['transaction_id' => $transactions->getTransactionId()];
        }

        // Steps
        $this->transactionIndex->open();
        $this->transactionIndex->getTransactionGrid()
            ->massaction($changeStatusTransactions, [$this->changeStatusTransactions => $gridStatus]);
        return $changeStatusTransactions;
    }
}
