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


class AssertCheckoutPaymentMethodCP222 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amount)
    {
        $remain = $webposIndex->getCheckoutPlaceOrder()->getRemainMoneyPrice()->getText();
        $total = $webposIndex->getCheckoutPlaceOrder()->getTopTotalPrice()->getText();
        \PHPUnit_Framework_Assert::assertEquals(
            $amount,
            substr($remain, 1),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Remain money less fill amount.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutPlaceOrder()->getInvoiceBox()->isVisible(),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Create invoice is visiable.'
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