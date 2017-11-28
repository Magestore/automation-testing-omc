<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 11/28/2017
 * Time: 10:09 AM
 */
namespace Magento\Rewardpoints\Test\Constraint\Transaction;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\TransactionNew;

class AssertTransactionFormAvailable extends AbstractConstraint
{

    public function processAssert(TransactionNew $transactionNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $transactionNew->getTransactionForm()->isVisible(),
            'Transaction form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $transactionNew->getTransactionForm()->formTitleIsVisible(),
            'Transaction form title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $transactionNew->getTransactionForm()->customerFieldIsVisible(),
            'Customer field is not visible.'
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