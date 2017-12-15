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
use Magento\Rewardpoints\Test\Fixture\Rate;
use Magento\Rewardpoints\Test\Fixture\Transaction;


class CreateTransactionsEntityTest extends Injectable
{


    protected $transactionIndex;


    protected $transactionNew;


    public function __inject(TransactionIndex $transactionIndex, TransactionNew $transactionNew)
    {
        $this->transactionIndex = $transactionIndex;
        $this->transactionNew = $transactionNew;
    }


    public function test($button, Customer $customer)
    {
//        $rate->persist();
        $customer->persist();

        $this->transactionIndex->open();
        $this->transactionIndex->getTransactionGridPageActions()->clickActionButton($button);
        $this->transactionNew->getTransactionForm()->selectedCustomer($customer);
//        $this->transactionNew->getTransactionFormPageActions()->save();
    }
}