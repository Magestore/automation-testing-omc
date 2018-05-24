<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/23/18
 * Time: 3:23 PM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagementValidate\TakeMoneyOut;

use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertWebposCheckValidateAmountFieldSM23Test
 * @package Magento\Webpos\Test\Constraint\SessionManagementValidate\TakeMoneyOut
 */
class AssertWebposCheckValidateAmountFieldSM23Test extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $staff
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Remove amount must be less than the balance!',
            $webposIndex->getPutMoneyInPopup()->getErrorMessage()->getText(),
            'Take Payment Popup In Session Management. You have to enter value less than the balance! You cannot Save Done Take Payment. Please try again.'
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