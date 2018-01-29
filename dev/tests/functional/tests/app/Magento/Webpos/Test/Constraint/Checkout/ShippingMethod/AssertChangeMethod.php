<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 17/01/2018
 * Time: 12:01
 */
namespace Magento\Webpos\Test\Constraint\Checkout\ShippingMethod;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertChangeMethod extends AbstractConstraint
{
    public function processAssert($shippingMethodBefore, $shippingMethodAfter, $shippingMethodBeforeActual, $shippingMethodAfterActual)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            floatval($shippingMethodBefore[0]),
            floatval($shippingMethodBeforeActual[0]),
            'Update price is not fit'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $shippingMethodBefore[1],
            $shippingMethodBeforeActual[1],
            'Update title is not fit'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            floatval($shippingMethodAfter[0]),
            floatval($shippingMethodAfterActual[0]),
            'Update price is not fit'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            floatval($shippingMethodAfter[1]),
            floatval($shippingMethodAfterActual[1]),
            'Update title is not fit'
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