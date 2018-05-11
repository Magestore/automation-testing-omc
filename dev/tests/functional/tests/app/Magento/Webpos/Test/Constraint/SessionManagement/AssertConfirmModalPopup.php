<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/12/2018
 * Time: 4:19 PM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagement;

use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertConfirmModalPopup
 * @package Magento\Webpos\Test\Constraint\SessionManagement
 */
class AssertConfirmModalPopup extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $realBalance
     * @param $theoryIs
     * @param $loss
     */
    public function processAssert(WebposIndex $webposIndex, $realBalance, $theoryIs, $loss)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            "Theory is not the same as the real balance. Do you want to continue?",
            $webposIndex->getSessionConfirmModalPopup()->getModalTitle()->getText(),
            'Message is not correct.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $realBalance,
            $webposIndex->getSessionConfirmModalPopup()->getRealBalance(),
            'Notice is not correct.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $theoryIs,
            $webposIndex->getSessionConfirmModalPopup()->getTheoryIs(),
            'Notice is not correct.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $loss,
            $webposIndex->getSessionConfirmModalPopup()->getLoss(),
            'Notice is not correct.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionConfirmModalPopup()->getCancelButton()->isVisible(),
            'Cancel Button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionConfirmModalPopup()->getOkButton()->isVisible(),
            'Ok Button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionConfirmModalPopup()->getCloseButton()->isVisible(),
            'Close Button is not visible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Confirm Modal Popup is correct.';
    }
}