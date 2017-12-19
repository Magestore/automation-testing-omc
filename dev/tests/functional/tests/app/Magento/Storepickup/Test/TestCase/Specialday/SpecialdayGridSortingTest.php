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

class SpecialdayGridSortingTest extends GridSortingTest
{
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $specialday = $fixtureFactory->createByCode('storepickupSpecialday', ['dataset' => 'specialday1']);
        $specialday->persist();
    }
}