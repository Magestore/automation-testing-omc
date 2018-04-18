<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Form;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertStaffSuccessSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffIndex $staffIndex
     * @return void
     */
    public function processAssert(StaffIndex $staffIndex, $message)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $staffIndex->getMessagesBlock()->getSuccessMessage(),
            'Message success is not match'
        );
    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Message success matchs';
    }
}
