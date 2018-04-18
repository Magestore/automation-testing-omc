<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/15/2017
 * Time: 2:38 PM
 */

namespace Magento\Rewardpoints\Test\Constraint\Transaction;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\TransactionNew;


/**
 * Class AssertTransactionRequiredForm
 * @package Magento\Rewardpoints\Test\Constraint\Transaction
 */
class AssertTransactionRequiredForm extends AbstractConstraint
{

    /**
     * @param TransactionNew $transactionNew
     */
    public function processAssert(TransactionNew $transactionNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $transactionNew->getTransactionForm()->fieldErrorIsVisible(),
            'Transaction required field form is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Transaction form is available.';
    }
}