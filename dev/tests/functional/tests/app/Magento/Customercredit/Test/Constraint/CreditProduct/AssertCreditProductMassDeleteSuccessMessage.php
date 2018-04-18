<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/20/2017
 * Time: 1:31 PM
 */

namespace Magento\Customercredit\Test\Constraint\CreditProduct;

use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCreditProductMassDeleteSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after deletion via mass actions
     */
    const SUCCESS_DELETE_MESSAGE = 'Total of %d record(s) have been deleted.';

    /**
     * Assert that message "Total of "x" record(s) have been deleted."
     *
     * @param productQtyToDelete
     * @param CreditProductIndex $creditProductIndex
     * @return void
     */
    public function processAssert($productQtyToDelete, CreditProductIndex $creditProductIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_DELETE_MESSAGE, $productQtyToDelete),
            $creditProductIndex->getMessagesBlock()->getSuccessMessage(),
            'Wrong delete message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Mass delete credit product message is displayed.';
    }
}