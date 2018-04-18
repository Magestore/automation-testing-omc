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


class AssertCheckoutPaymentMethodCP238 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {

        \PHPUnit_Framework_Assert::assertNotTrue(
            $webposIndex->getCheckoutCartItems()->getFirstCartItem()->isVisible(),
            'TaxClass page - CategoryRepository. Default Cart'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            1,
            $webposIndex->getNotification()->getCountNotification()->getText(),
            'TaxClass page - CategoryRepository. Count Notification'
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