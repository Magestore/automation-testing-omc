<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/21/18
 * Time: 9:30 AM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagementValidate\TakeMoneyOut;

use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertWebposCheckValidateAmountFieldSM20SM21
 * @package Magento\Webpos\Test\Constraint\SessionManagementValidate\TakeMoneyOut
 */
class AssertWebposCheckValidateAmountFieldSM20SM21 extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $staff
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Amount must be greater than 0!',
            $webposIndex->getPutMoneyInPopup()->getErrorMessage()->getText(),
            'Take Payment Popup In Session Management. If you not enter value to amount input. You cannot Save Done Take Payment. Please try again.'
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