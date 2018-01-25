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


class AssertCheckoutPaymentMethodCP223 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
//        $totalpaid = $webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->getText();
//        $total = $webposIndex->getCheckoutPlaceOrder()->getTopTotalPrice()->getText();
//        $remain = $webposIndex->getCheckoutPlaceOrder()->getRemainMoneyPrice()->getText();
//        \PHPUnit_Framework_Assert::assertEquals(
//            substr($total, 1)+$amount,
//            substr($totalpaid, 1),
//            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Total paid.'
//            . "\nExpected: " . (substr($total, 1)+$amount)
//            . "\nActual: " . substr($totalpaid, 1)
//        );
//        \PHPUnit_Framework_Assert::assertEquals(
//            $amount,
//            substr($remain, 1),
//            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Change Remain money.'
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