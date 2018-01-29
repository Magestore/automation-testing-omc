<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/16/2018
 * Time: 3:35 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxAmountOnOrderHistoryInvoiceWithTaxCaculationBaseOnBilling extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $taxRate)
    {
        $subtotal = substr($webposIndex->getOrderHistoryInvoice()->getSubtotal(), 1);
        $taxAmount = $subtotal * $taxRate / 100;
        $actualTaxAmount = substr($webposIndex->getOrderHistoryInvoice()->getTaxAmount(), 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmount,
            $actualTaxAmount,
            'tax amount is not equals actual tax amount.'
            . "\nExpected: " . $taxAmount
            . "\nActual: " . $actualTaxAmount
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'tax amount is equals actual tax amount.';
    }
}