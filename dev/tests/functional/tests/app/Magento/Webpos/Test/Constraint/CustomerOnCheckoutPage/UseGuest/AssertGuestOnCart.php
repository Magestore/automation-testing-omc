<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/28/2018
 * Time: 10:24 AM
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\UseGuest;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertGuestOnCart
 * @package Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\UseGuest
 */
class AssertGuestOnCart extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Guest',
            $webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->getText(),
            "Customer on checkout page - Use Guest - Customer's name is wrong"
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Customer on checkout page - Use Guest - Customer's name is correct";
    }
}