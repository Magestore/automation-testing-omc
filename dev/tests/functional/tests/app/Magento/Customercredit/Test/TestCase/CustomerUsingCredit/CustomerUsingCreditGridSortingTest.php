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

class CustomerUsingCreditGridSortingTest extends GridSortingTest
{
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $customerUseCredit = $fixtureFactory->createByCode('customerUseCredit', ['dataset' => 'default1']);
        $customerUseCredit->persist();
    }
}