<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/26/2018
 * Time: 9:34 AM
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\Search;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCutomerTelephoneSearch extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, Customer $customer)
    {
        $customerTelephones = $webposIndex->getCheckoutChangeCustomer()->getCustomerTelePhones();
        $expectedCustomerTelephone = $customer->getAddress()[0]['telephone'];
        foreach ($customerTelephones as $customerTelephone) {
            \PHPUnit_Framework_Assert::assertEquals(
                $expectedCustomerTelephone,
                $customerTelephone,
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