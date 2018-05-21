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

/**
 * Preconditions:
 * 1. Create transactions according to data set.
 *
 * Steps:
 * 1. LoginTest to backend.
 * 2. Navigate Reward points > Transactions
 * 3. Select transaction created in preconditions.
 * 4. Select Change status action from mass-action.
 * 5. Select Canceled
 * 6. Perform asserts.
 *
 */
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
