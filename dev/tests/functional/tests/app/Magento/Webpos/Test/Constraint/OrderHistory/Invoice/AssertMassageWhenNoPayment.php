<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/2/2018
 * Time: 2:07 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertMassageWhenNoPayment
 * @package Magento\Webpos\Test\Constraint\OrderHistory\Invoice
 */
class AssertMassageWhenNoPayment extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'You must take payment on this order before creating invoice',
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            "Warning message's Content is Wrong"
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Invoice Warning Message was visible";
    }
}