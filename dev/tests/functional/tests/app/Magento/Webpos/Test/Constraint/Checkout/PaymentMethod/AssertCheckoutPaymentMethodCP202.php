<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/17/2018
 * Time: 8:24 AM
 */
namespace Magento\Webpos\Test\Constraint\Checkout\PaymentMethod;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertCheckoutPaymentMethodCP202
 * @package Magento\Webpos\Test\Constraint\Checkout\PaymentMethod
 */
class AssertCheckoutPaymentMethodCP202 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
//        \PHPUnit_Framework_Assert::assertNotTrue(
//            $webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->isVisible(),
//            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Payment is visible.'
//        );
//        \PHPUnit_Framework_Assert::assertTrue(
//            $webposIndex->getCheckoutPlaceOrder()->getButtonAddPayment()->isVisible(),
//            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Payment is visible.'
//        );
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