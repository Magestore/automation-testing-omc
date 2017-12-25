<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/14/2017
 * Time: 1:31 PM
 */

namespace Magento\Rewardpoints\Test\TestCase\Transactions;

use Magento\Mtf\TestCase\Injectable;
use Magento\Rewardpoints\Test\Page\Adminhtml\TransactionIndex;
use Magento\Rewardpoints\Test\Page\Adminhtml\TransactionNew;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Rewardpoints\Test\Fixture\Transaction;

/**
 *  * Preconditions:
 * 1. Create customer
 *
 * Test Flow:
 * 1. Login as admin
 * 2. Navigate to the Reward points>Earning Rates
 * 3. Click on 'Add New Earning Rate' button
 * 4. Click on 'Select' button
 * 5. Filter email customer
 * 6. Click on customer
 * 7. Fill out all data
 * 8. Save
 * 9. Verify created
 *
 */

/**
 * Class CreateTransactionsEntityTest
 * @package Magento\Rewardpoints\Test\TestCase\Transactions
 */
class CreateTransactionsEntityTest extends Injectable
{

    /**
     * @var TransactionIndex
     */
    protected $transactionIndex;

    /**
     * @var TransactionNew
     */
    protected $transactionNew;

    /**
     * @param TransactionIndex $transactionIndex
     * @param TransactionNew $transactionNew
     */
    public function __inject(TransactionIndex $transactionIndex, TransactionNew $transactionNew)
    {
        $this->transactionIndex = $transactionIndex;
        $this->transactionNew = $transactionNew;
    }

    public function test($button, Customer $customer, Transaction $transaction)
    {
//        $rate->persist();
        $customer->persist();

        $this->transactionIndex->open();
        $this->transactionIndex->getTransactionGridPageActions()->clickActionButton($button);
        $this->transactionNew->getTransactionForm()->clickSelectCustomer();
        $this->transactionNew->getSelectCustomerForm()->selectedCustomer($customer);
        $this->transactionNew->getTransactionForm()->fill($transaction);
        $this->transactionNew->getTransactionFormPageActions()->save();
    }
}