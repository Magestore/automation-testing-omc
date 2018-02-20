<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/02/2018
 * Time: 20:31
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Form;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertValidationEmailExist extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffNews $staffNews
     * @return void
     */
    public function processAssert(StaffNews $staffNews, $message)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $staffNews->getMessagesBlock()->getErrorMessage(),
            'Message is not fit'
        );


    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Message is correct';
    }
}
