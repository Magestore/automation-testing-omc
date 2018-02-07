<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 01/02/2018
 * Time: 15:29
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\Processing;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCheckFeeShippingLoadCart extends AbstractConstraint
{
    public function processAssert($feeShippingBefore, $feeShippingAfter)
    {

        \PHPUnit_Framework_Assert::assertEquals(
            $feeShippingBefore,
            $feeShippingAfter,
            'Fee shipping is not load cart correct'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Fee shipping is correct";
    }
}