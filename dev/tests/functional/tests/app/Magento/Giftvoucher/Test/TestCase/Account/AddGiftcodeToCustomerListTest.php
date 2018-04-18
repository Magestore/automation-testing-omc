<?php

namespace Magento\Giftvoucher\Test\TestCase\Account;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\TestCase\Scenario;

class AddGiftcodeToCustomerListTest extends Scenario
{
    public function __prepare(Customer $customer)
    {
        $customer->persist();
        return ['customer' => $customer];
    }

    /**
     * Runs the scenario test case
     *
     * @return void
     */
    public function test()
    {
        $this->executeScenario();
    }
}
