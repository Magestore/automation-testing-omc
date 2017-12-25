<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 3:37 PM
 */

namespace Magento\Storepickup\Test\TestCase\Holiday;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\HolidayIndex;

/**
 *
 * Test Flow:
 * Preconditions:
 * 1. Create X products
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  Store Pickup > Manage Holiday
 * 3. Select N products from preconditions
 * 4. Select in dropdown "Delete"
 * 5. Accept alert
 * 6. Perform all assertions according to dataset
 *
 */
class MassDeleteHolidayBackendEntityTest extends Injectable
{
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var HolidayIndex
     */
    protected $holidayIndex;

    /**
     * @param FixtureFactory $fixtureFactory
     * @param HolidayIndex $holidayIndex
     */
    public function __inject(
        FixtureFactory $fixtureFactory,
        HolidayIndex $holidayIndex
    ){
        $this->fixtureFactory = $fixtureFactory;
        $this->holidayIndex = $holidayIndex;
        $holidayIndex->open();
        $holidayIndex->getHolidayGrid()->massaction([], 'Delete', true, 'Select All');
    }

    public function test($holidaysQty, $holidaysQtyToDelete)
    {
        $holidays = $this->createHolidays($holidaysQty);
        $deleteHolidays = [];
        for ($i = 0; $i < $holidaysQtyToDelete; $i++) {
            $deleteHolidays[] = ['name' => $holidays[$i]->getHolidayName()];
        }
        $this->holidayIndex->open();
        $this->holidayIndex->getHolidayGrid()->massaction($deleteHolidays, 'Delete', true);

        return ['holidays' => $holidays];
    }

    public function createHolidays($holidaysQty)
    {
        $holidays = [];
        for ($i = 0; $i < $holidaysQty; $i++) {
            $holiday = $this->fixtureFactory->createByCode('storepickupHoliday', ['dataset' => 'default1']);
            $holiday->persist();
            $holidays[] = $holiday;
        }
        return $holidays;
    }
}