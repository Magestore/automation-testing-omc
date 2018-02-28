<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/26/2018
 * Time: 8:58 AM
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\Search;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCustomerNameSearch extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, Customer $customer)
    {
        $customerNames = $webposIndex->getCheckoutChangeCustomer()->getCustomerNames();
        $expectedCustomerName = $customer->getFirstname() . ' ' . $customer->getLastname();
        foreach ($customerNames as $customerName) {
            \PHPUnit_Framework_Assert::assertEquals(
                $expectedCustomerName,
                $customerName,
                'Cutomer result is wrong.'
            );
        }
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Customer results are available.';
    }
}