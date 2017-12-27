<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 1:25 PM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

class AssertStoreMassDisableSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after disable via mass actions
     */
    const SUCCESS_DISABLE_MESSAGE = 'A total of %d record(s) have been disabled.';

    /**
     * Assert that message "A total of "x" record(s) have been disabled."
     *
     * @param $storeQty
     * @param StoreIndex $storeIndex
     * @return void
     */
    public function processAssert($storesQty, StoreIndex $storeIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_DISABLE_MESSAGE, $storesQty),
            $storeIndex->getMessagesBlock()->getSuccessMessage(),
            'Wrong disable message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Mass disable store message is displayed.';
    }
}