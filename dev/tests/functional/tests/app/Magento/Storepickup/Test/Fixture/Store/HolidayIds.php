<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 9:43 PM
 */

namespace Magento\Storepickup\Test\Fixture\Store;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class HolidayIds extends DataSource
{
    protected $holidays = [];

    public function __construct(
        FixtureFactory $fixtureFactory,
        array $params,
        array $data = []
    ) {
        $this->params = $params;
        if (isset($data['dataset']) && $data['dataset'] !== '-') {
            $datasets = explode(',', $data['dataset']);
            foreach ($datasets as $dataset) {
                $holiday = $fixtureFactory->createByCode('storepickupHoliday', ['dataset' => trim($dataset)]);
                if (!$holiday->hasData('holiday_id')) {
                    $holiday->persist();
                }
                $this->holidays[] = $holiday;
                $this->data[] = [
                    'name' => $holiday->getHolidayName()
                ];
            }
        }
    }

    /**
     * Return related products.
     *
     * @return array
     */
    public function getHolidays()
    {
        return $this->holidays;
    }
}