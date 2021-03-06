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


class AssertCheckoutPaymentMethodCP216 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amount)
    {
        $webposIndex->getOrderHistoryOrderViewHeader()->waitForChangeStatus("Processing");
        \PHPUnit_Framework_Assert::assertEquals(
            "Processing",
            $webposIndex->getOrderHistoryOrderViewHeader()->getStatus(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Status order Processing.'
        );

        $totalpaid = $webposIndex->getOrderHistoryOrderViewFooter()->getTotalPaid();
        \PHPUnit_Framework_Assert::assertEquals(
            $amount,
            substr($totalpaid, 1),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Status order total paid.'
        );

//        \PHPUnit_Framework_Assert::assertTrue(
//            $webposIndex->getOrderHistoryOrderViewHeader()->getButtonTakePayment()->isVisible(),
//            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Take Payment visible.'
//        );

//        \PHPUnit_Framework_Assert::assertTrue(
//            $webposIndex->getOrderHistoryOrderViewHeader()->getPrintButton()->isVisible(),
//            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Print visible.'
//        );
//
//        \PHPUnit_Framework_Assert::assertTrue(
//            $webposIndex->OrderHistoryOrderViewHeader()->getInvoiceButton()->isVisible(),
//            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Invoice visible.'
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