<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/21/18
 * Time: 9:00 AM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagementValidate\TakeMoneyOut;

use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertWebposCheckGUITakeMoneyOutSM18
 * @package Webpos\Test\Constraint\SessionManagementValidate\TakeMoneyOut
 */
class AssertWebposCheckGUITakeMoneyOutSM18 extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $staff
     */
    public function processAssert(WebposIndex $webposIndex, $username)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getPutMoneyInPopup()->getBtnCancel()->isVisible(),
            'Take Payment Popup In Session Management. Button Cancel is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getPutMoneyInPopup()->getTitleForm()->isVisible(),
            'Take Payment Popup In Session Management. Title Form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getPutMoneyInPopup()->getDoneButton()->isVisible(),
            'Take Payment Popup In Session Management. Button Done is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getPutMoneyInPopup()->getAmountInput()->isVisible(),
            'Take Payment Popup In Session Management. Amount Input is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getPutMoneyInPopup()->getReasonInput()->isVisible(),
            'Take Payment Popup In Session Management. Reason Input is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getPutMoneyInPopup()->getFormDescription()->isVisible(),
            'Take Payment Popup In Session Management. Form Description is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getPutMoneyInPopup()->getStaffName()->isVisible(),
            'Take Payment Popup In Session Management. Staff Name is not visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $username. ' ' .$username,
            $webposIndex->getPutMoneyInPopup()->getStaffName()->getText(),
            'Take Payment Popup In Session Management. Staff Name Is not Visible Correctly.'
        );
        $amountInput = substr($webposIndex->getPutMoneyInPopup()->getAmountInput()->getValue(),1);
        \PHPUnit_Framework_Assert::assertEquals(
            $amountInput,
            '0.00',
            'Take Payment Popup In Session Management. Value Of Amount Input Is not Visible Correctly.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Take Payment Popup In Session Management. Every Element Visible Correctly.';
    }
}