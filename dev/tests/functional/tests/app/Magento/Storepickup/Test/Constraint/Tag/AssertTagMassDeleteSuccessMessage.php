<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 2:44 PM
 */

namespace Magento\Storepickup\Test\Constraint\Tag;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\TagIndex;

class AssertTagMassDeleteSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after deletion via mass actions
     */
    const SUCCESS_DELETE_MESSAGE = 'A total of %d record(s) have been deleted.';

    /**
     * Assert that message "A total of "x" record(s) were deleted."
     *
     * @param $tagsQtyToDelete
     * @param TagIndex $tagIndex
     * @return void
     */
    public function processAssert($tagsQtyToDelete, TagIndex $tagIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_DELETE_MESSAGE, $tagsQtyToDelete),
            $tagIndex->getMessagesBlock()->getSuccessMessage(),
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
        return 'Mass delete tag message is displayed.';
    }
}