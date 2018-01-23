<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/17/2018
 * Time: 10:52 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxAmountWithApplyTaxOnCustomPrice extends AbstractConstraint
{
    public function processAssert($customPrice, $actualTaxAmount, $taxRate)
    {
        $taxAmount = $customPrice * $taxRate / 100;
        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmount,
            $actualTaxAmount,
            'Tax amount is not equals actual tax amount.'
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
        return 'Tax Amount is correct.';
    }
}