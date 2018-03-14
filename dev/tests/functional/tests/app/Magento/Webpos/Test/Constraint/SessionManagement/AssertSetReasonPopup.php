<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/14/2018
 * Time: 8:44 AM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagement;

use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertSetReasonPopup
 * @package Magento\Webpos\Test\Constraint\SessionManagement
 */
class AssertSetReasonPopup extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            "Fill in this form the reason to loss/profit before closing Session",
            $webposIndex->getSessionSetReasonPopup()->getNotice()->getText(),
            'Message is not correct.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetReasonPopup()->getCancelButton()->isVisible(),
            'Cancel Button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetReasonPopup()->getConfirmButton()->isVisible(),
            'Confirm Button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetReasonPopup()->getReason()->isVisible(),
            'Reason is not visible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Set Reason Popup is correct.';
    }
}