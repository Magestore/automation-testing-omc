<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/11/2017
 * Time: 1:54 PM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

class AssertStoreSuccessSaveMessage extends AbstractConstraint
{
    const SUCCESS_SAVE_MESSAGE = 'The Store has been saved.';

    public function processAssert(StoreIndex $storeIndex)
    {
        $actualMessage = $storeIndex->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_SAVE_MESSAGE,
            $actualMessage,
            'Wrong success message is displayed.'
            . "\nExpected: " . self::SUCCESS_SAVE_MESSAGE
            . "\nActual: " . $actualMessage
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Store success create message is present.';
    }
}