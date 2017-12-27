<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 11:31 AM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

class AssertStoreMassEnableSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after enable via mass actions
     */
    const SUCCESS_ENABLE_MESSAGE = 'A total of %d record(s) have been enabled.';

    /**
     * Assert that message "A total of "x" record(s) have been enabled."
     *
     * @param $storeQty
     * @param StoreIndex $storeIndex
     * @return void
     */
    public function processAssert($storesQty, StoreIndex $storeIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_ENABLE_MESSAGE, $storesQty),
            $storeIndex->getMessagesBlock()->getSuccessMessage(),
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
        return 'Mass enable store message is displayed.';
    }
}