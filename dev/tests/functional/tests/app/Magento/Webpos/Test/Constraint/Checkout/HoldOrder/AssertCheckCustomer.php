<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 21/01/2018
 * Time: 20:37
 */
namespace Magento\Webpos\Test\Constraint\Checkout\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Customer\Test\Fixture\Customer;

class AssertCheckCustomer extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex,Customer $customer)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $customer->getFirstname().' '.$customer->getLastname(),
            $webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->getText(),
            'Customer is not display'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Customer is display correct";
    }
}