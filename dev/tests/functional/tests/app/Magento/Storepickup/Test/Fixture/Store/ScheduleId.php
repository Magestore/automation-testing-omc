<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 5:54 PM
 */

namespace Magento\Storepickup\Test\Fixture\Store;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class ScheduleId extends DataSource
{
    protected $schedule;

    public function __construct(
        FixtureFactory $fixtureFactory,
        array $params,
        array $data = []
    ) {
        $this->params = $params;
        if (isset($data['dataset']) && $data['dataset'] !== '-') {
                $dataset = $data['dataset'];
                $schedule = $fixtureFactory->createByCode('storepickupSchedule', ['dataset' => trim($dataset)]);
                if (!$schedule->hasData('schedule_id')) {
                    $schedule->persist();
                }
                $this->schedule = $schedule;
                $this->data = $schedule->getScheduleName();

        }
    }

    /**
     * Return related products.
     *
     * @return array
     */
    public function getSchedule()
    {
        return $this->schedule;
    }
}