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


class AssertCheckoutPaymentMethodCP225 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {

        \PHPUnit_Framework_Assert::assertEquals(
            "Web POS - Cash In",
            $webposIndex->getOrderHistoryOrderViewContent()->getPaymentMethodName(1)->getText(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Two Payment order Detail.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            "Web POS - Credit Card",
            $webposIndex->getOrderHistoryOrderViewContent()->getPaymentMethodName(2)->getText(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Two Payment order Detail.'
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