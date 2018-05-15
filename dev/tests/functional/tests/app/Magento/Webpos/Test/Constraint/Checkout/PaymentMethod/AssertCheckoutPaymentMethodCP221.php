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


class AssertCheckoutPaymentMethodCP221 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        $webposIndex->getOrderHistoryOrderViewHeader()->waitForChangeStatus("Complete");
        \PHPUnit_Framework_Assert::assertEquals(
            "Complete",
            $webposIndex->getOrderHistoryOrderViewHeader()->getStatus(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Status order Complete.'
        );

        $totalpaid = $webposIndex->getOrderHistoryOrderViewFooter()->getTotalPaid();
        $grandtotal = $webposIndex->getOrderHistoryOrderViewFooter()->getGrandTotal();
        \PHPUnit_Framework_Assert::assertEquals(
            substr($grandtotal, 1),
            substr($totalpaid, 1),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Total paid.'
        );

        \PHPUnit_Framework_Assert::assertNotTrue(
            $webposIndex->getOrderHistoryOrderViewHeader()->getButtonTakePayment()->isVisible(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Take Payment not visible.'
        );

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderViewFooter()->getPrintButton()->isVisible(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Print visible.'
        );

        \PHPUnit_Framework_Assert::assertNotTrue(
            $webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->isVisible(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Invoice visible.'
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