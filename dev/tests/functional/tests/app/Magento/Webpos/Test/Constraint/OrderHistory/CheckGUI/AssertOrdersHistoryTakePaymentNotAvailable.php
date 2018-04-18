<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/1/2018
 * Time: 4:14 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertOrdersHistoryTakePaymentNotAvailable
 * @package Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI
 */
class AssertOrdersHistoryTakePaymentNotAvailable extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->isVisible(),
            'Take payment is visible.'
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Take payment is not available.';
    }
}