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


class AssertCheckoutPaymentMethodCP217 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        $remain = $webposIndex->getCheckoutPlaceOrder()->getRemainMoneyPrice()->getText();
        \PHPUnit_Framework_Assert::assertEquals(
            0.00,
            substr($remain, 1),
            'TaxClass page - CategoryRepository. On Tab PaymentMethod. Remain money equals fill amount.'
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