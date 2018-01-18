<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/17/2018
 * Time: 1:21 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertProductPriceOnRefundPopupWithApplyTaxOnCustomPrice extends AbstractConstraint
{
    public function processAssert($customPrice, $actualProductPrice, $taxRate)
    {
        $productPrice = $customPrice * (1 + $taxRate/100);
        \PHPUnit_Framework_Assert::assertEquals(
            $productPrice,
            $actualProductPrice,
            'Product price is not equals actual product price.'
            . "\nExpected: " . $productPrice
            . "\nActual: " . $actualProductPrice
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product price is correct.';
    }
}