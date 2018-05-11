<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Form;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertLocationSuccessSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param LocationIndex
     * @return void
     */
    public function processAssert(LocationIndex $locationIndex, $message)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $locationIndex->getMessagesBlock()->getSuccessMessage(),
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
