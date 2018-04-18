<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/20/2017
 * Time: 2:26 PM
 */

namespace Magento\Customercredit\Test\Constraint\CreditProduct;

use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCreditProductMassChangeStatusSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after change status via mass actions
     */
    const SUCCESS_ENABLE_MESSAGE = 'Total of %d record(s) have been updated.';

    /**
     * Assert that message "Total of 'x' record(s) have been updated."
     *
     * @param productsQty
     * @param CreditProductIndex $creditProductIndex
     * @return void
     */
    public function processAssert($productsQty, CreditProductIndex $creditProductIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_ENABLE_MESSAGE, $productsQty),
            $creditProductIndex->getMessagesBlock()->getSuccessMessage(),
            'Wrong enable message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Mass enable credit product message is displayed.';
    }
}