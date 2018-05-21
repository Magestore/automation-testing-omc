<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/21/18
 * Time: 9:19 AM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagementValidate\TakeMoneyOut;

use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertWebposCheckCancelButtonSM19
 * @package Magento\Webpos\Test\Constraint\SessionManagementValidate\TakeMoneyOut
 */
class AssertWebposCheckCancelButtonSM19 extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $staff
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getPutMoneyInPopup()->getBtnCancel()->isVisible(),
            'Take Payment Popup In Session Management. Button Cancel must have to be invisible.'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getPutMoneyInPopup()->getTitleForm()->isVisible(),
            'Take Payment Popup In Session Management. Title Form must have to be invisible.'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getPutMoneyInPopup()->getDoneButton()->isVisible(),
            'Take Payment Popup In Session Management. Button Done must have to be invisible.'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getPutMoneyInPopup()->getAmountInput()->isVisible(),
            'Take Payment Popup In Session Management. Amount Input must have to be invisible.'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getPutMoneyInPopup()->getReasonInput()->isVisible(),
            'Take Payment Popup In Session Management. Reason Input must have to be invisible.'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getPutMoneyInPopup()->getFormDescription()->isVisible(),
            'Take Payment Popup In Session Management. Form Description must have to be invisible.'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getPutMoneyInPopup()->getStaffName()->isVisible(),
            'Take Payment Popup In Session Management. Staff Name must have to be invisible.'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getPutMoneyInPopup()->isVisible(),
            'Take Payment Popup In Session Management. get Put Money InPopup must have to be invisible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Take Payment Popup In Session Management. After Click Cancel, Popup Take Payment Close Successfully.';
    }
}