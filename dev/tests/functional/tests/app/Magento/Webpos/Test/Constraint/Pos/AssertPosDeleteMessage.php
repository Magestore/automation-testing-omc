<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 13/5/2018
 * Time: 17:13
 */

namespace Magento\Webpos\Test\Constraint\Pos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

/**
 * Class AssertPosDeleteMessage
 * @package Magento\Webpos\Test\Constraint\Pos
 */
class AssertPosDeleteMessage extends AbstractConstraint
{
    /**
     * @param PosIndex $posIndex
     */
    public function processAssert(PosIndex $posIndex, $itemCount = 1)
    {
        $actualMessage = $posIndex->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            'A total of ' . $itemCount . ' record(s) were deleted.',
            $actualMessage,
            'Wrong success message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Pos success delete message is present.';
    }
}