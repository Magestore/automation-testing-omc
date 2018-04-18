<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 5:59 PM
 */

namespace Magento\Storepickup\Test\TestCase\Specialday;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Ui\Test\TestCase\GridSortingTest;

/**
 * Precondition:
 * 1. Create items
 *
 * Steps:
 * 1. Navigate to backend.
 * 2. Go to grid page Store Pickup > Manage Special day.
 * 3. Sort grid using provided columns
 * 5. Perform Asserts
 *
 */
class SpecialdayGridSortingTest extends GridSortingTest
{
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $specialday = $fixtureFactory->createByCode('storepickupSpecialday', ['dataset' => 'specialday1']);
        $specialday->persist();
    }
}