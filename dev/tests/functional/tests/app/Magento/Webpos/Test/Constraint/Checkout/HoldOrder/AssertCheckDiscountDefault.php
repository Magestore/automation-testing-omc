<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 25/01/2018
 * Time: 13:13
 */
namespace Magento\Webpos\Test\Constraint\Checkout\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Customer\Test\Fixture\Customer;

class AssertCheckDiscountDefault extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
//        \PHPUnit_Framework_Assert::assertTrue(
//            $webposIndex->getCheckoutCartFooter()->isAddDiscountVisible(),
//            'Add discount is not display'
//        );
//
//        \PHPUnit_Framework_Assert::assertFalse(
//            $webposIndex->getCheckoutCartFooter()->isDiscountVisible(),
//            'Add discount is not display'
//        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Discount is not display : correct";
    }
}