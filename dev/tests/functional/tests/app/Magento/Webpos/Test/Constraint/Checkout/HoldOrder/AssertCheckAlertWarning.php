<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 17/01/2018
 * Time: 12:01
 */
namespace Magento\Webpos\Test\Constraint\Checkout\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCheckAlertWarning extends AbstractConstraint
{
    public function processAssert($warningMessageActual, $warningMessageExpected)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $warningMessageActual,
            $warningMessageExpected,
            'Warning Message Expected is not fit'
        );    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Warning Message Expected is correct";
    }
}