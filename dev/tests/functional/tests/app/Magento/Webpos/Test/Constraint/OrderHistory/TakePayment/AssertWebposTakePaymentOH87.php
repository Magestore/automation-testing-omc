<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/6/2018
 * Time: 9:02 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\TakePayment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertWebposTakePaymentOH87 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $message)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $webposIndex->getModal()->getPopupMessage(),
            'Message after click OK submit take payment display is not correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getModal()->getModalPopup()->isVisible(),
            'Visible close popup is not visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getModal()->getOkButton()->isVisible(),
            'Button OK is not visible correctly.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Order Status was correctly.";
    }
}