<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/24/2018
 * Time: 10:00 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertOrdersHistoryPageAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryContainer()->getOrdersList()->isVisible(),
            'Orders List is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryContainer()->getOrdersDetail()->isVisible(),
            'Orders Details is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Orders History page is available.';
    }
}