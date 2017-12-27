<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/21/2017
 * Time: 10:32 AM
 */

namespace Magento\Customercredit\Test\TestCase\CustomerUsingCredit;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Ui\Test\TestCase\GridSortingTest;
/**
 * Precondition:
 * 1. Create 2 items
 *
 * Steps:
 * 1. Navigate to backend Store Credit > Manage Customers Using Credit.
 * 2. Sort grid using provided columns
 * 3. Perform Asserts
 *
 */
class CustomerUsingCreditGridSortingTest extends GridSortingTest
{
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $customerUseCredit = $fixtureFactory->createByCode('customerUseCredit', ['dataset' => 'default1']);
        $customerUseCredit->persist();
    }
}