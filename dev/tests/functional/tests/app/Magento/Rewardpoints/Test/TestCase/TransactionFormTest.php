<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 8:48 AM
 */

namespace Magento\Rewardpoints\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Rewardpoints\Test\Page\Adminhtml\TransactionIndex;

/**
 *
 * Test Flow:
 * 1. LoginTest as admin
 * 2. Navigate to the Reward points>Transactions
 * 3. Click on 'Add New Transaction' button
 * 4. Verify form add new
 *
 */

/**
 * Class TransactionFormTest
 * @package Magento\Rewardpoints\Test\TestCase
 */
class TransactionFormTest extends Injectable
{
    /**
     * @var TransactionIndex
     */
    public $transactionIndex;

    /**
     * @param TransactionIndex $transactionIndex
     */
    public function __inject(TransactionIndex $transactionIndex)
    {
        $this->transactionIndex = $transactionIndex;
    }

    /**
     * @param $button
     */
    public function test($button)
    {
        $this->transactionIndex->open();
        $this->transactionIndex->getTransactionGridPageActions()->clickActionButton($button);
    }
}