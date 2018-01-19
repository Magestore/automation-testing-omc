<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/17/2018
 * Time: 9:03 AM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\PaymentMethod;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;


class AssertCheckoutPaymentMethodCP203 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        $message = "No payment method is available";
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            $webposIndex->getCheckoutPlaceOrder()->getMessageAddMorePayment()->getText(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Payment message.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "TaxClass page is default";
    }
}