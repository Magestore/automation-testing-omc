<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 1:32 PM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

class AssertStoreMassDeleteSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after delete via mass actions
     */
    const SUCCESS_DELETE_MESSAGE = 'A total of %d record(s) have been deleted.';

    /**
     * Assert that message "A total of "x" record(s) have been deleted."
     *
     * @param $storeQty
     * @param StoreIndex $storeIndex
     * @return void
     */
    public function processAssert($storesQty, StoreIndex $storeIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_DELETE_MESSAGE, $storesQty),
            $storeIndex->getMessagesBlock()->getSuccessMessage(),
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
        return 'Mass delete store message is displayed.';
    }
}