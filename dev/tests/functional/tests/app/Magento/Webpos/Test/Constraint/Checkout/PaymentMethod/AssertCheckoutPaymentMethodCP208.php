<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/17/2018
 * Time: 3:29 PM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\PaymentMethod;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;


class AssertCheckoutPaymentMethodCP208 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddMorePayment()->getCashIn()->isVisible(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Add More Payment is visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddMorePayment()->getCashOnDeliveryMethod()->isVisible(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Add More Payment is visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddMorePayment()->getCreditCard()->isVisible(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Add More Payment is visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddMorePayment()->getCustomPayment1()->isVisible(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Add More Payment is visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddMorePayment()->getCustomPayment2()->isVisible(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Add More Payment is visible.'
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