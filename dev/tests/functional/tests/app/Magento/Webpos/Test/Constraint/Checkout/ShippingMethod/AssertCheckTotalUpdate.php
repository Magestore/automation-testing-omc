<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 17/01/2018
 * Time: 12:36
 */
namespace Magento\Webpos\Test\Constraint\Checkout\ShippingMethod;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCheckTotalUpdate extends AbstractConstraint
{
    public function processAssert($priceShipping, $total, $subtotal, $tax)
    {
        $totalActual = floatval($priceShipping) + $subtotal + $tax;
        \PHPUnit_Framework_Assert::assertEquals(
            $totalActual,
            $total,
            'Update total is not fit'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Update shipping method is correct";
    }
}