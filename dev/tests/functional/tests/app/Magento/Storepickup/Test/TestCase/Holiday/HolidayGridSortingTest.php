<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 5:47 PM
 */

namespace Magento\Storepickup\Test\TestCase\Holiday;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Ui\Test\TestCase\GridSortingTest;

class HolidayGridSortingTest extends GridSortingTest
{
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $holiday = $fixtureFactory->createByCode('storepickupHoliday', ['dataset' => 'holiday1']);
        $holiday->persist();
    }
}