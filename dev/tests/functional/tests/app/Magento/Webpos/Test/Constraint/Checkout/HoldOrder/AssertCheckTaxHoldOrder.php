<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 25/01/2018
 * Time: 13:57
 */
namespace Magento\Webpos\Test\Constraint\Checkout\HoldOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertCheckTaxHoldOrder
 * @package Magento\Webpos\Test\Constraint\Cart\HoldOrder
 */
class AssertCheckTaxHoldOrder extends AbstractConstraint
{
    /**
     * @param $taxExpected
     * @param $taxActual
     */
    public function processAssert($taxExpected, $taxActual)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $taxExpected,
            $taxActual,
            'Tax is not correct, taxExpected is : $'.$taxExpected.'and taxActual is : $'.$taxActual
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Tax before and after hold order is correct";
    }
}