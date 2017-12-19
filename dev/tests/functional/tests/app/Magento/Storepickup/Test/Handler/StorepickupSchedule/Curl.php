<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 4:38 PM
 */

namespace Magento\Storepickup\Test\Handler\StorepickupSchedule;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl extends AbstractCurl implements StorepickupScheduleInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'storepickupadmin/schedule/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        'monday_status' => [
          'Open' =>'1',
          'Close' => '2'
        ],
        'tuesday_status' => [
            'Open' =>'1',
            'Close' => '2'
        ],
        'wednesday_status' => [
            'Open' =>'1',
            'Close' => '2'
        ],
        'thursday_status' => [
            'Open' =>'1',
            'Close' => '2'
        ],
        'friday_status' => [
            'Open' =>'1',
            'Close' => '2'
        ],
        'saturday_status' => [
            'Open' =>'1',
            'Close' => '2'
        ],
        'sunday_status' => [
            'Open' =>'1',
            'Close' => '2'
        ],
    ];

    /**
     *
     * @param FixtureInterface|null $fixture [optional]
     * @return array
     * @throws \Exception
     */
    public function persist(FixtureInterface $fixture = null)
    {
        $data = $this->replaceMappingData($fixture->getData());
        $data = $this->prepareScheduleData($data);
        if ($fixture->hasData('storepickup_stores')) {
            $stores = $fixture->getDataFieldConfig('storepickup_stores')['source']->getStores();
            $serialized_stores = '';
            foreach ($stores as $store) {
                if($serialized_stores == ''){
                    $serialized_stores = $store->getStorepickupId();
                } else {
                    $serialized_stores .= '&' . $store->getStorepickupId();
                }
            }
            $data['serialized_stores'] = $serialized_stores;
        }
        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Store Schedule entity creation by curl handler was not successful! Response: $response"
            );
        }

        preg_match_all('/\"schedule_id\":\"(\d+)\"/', $response, $matches);
        $id = $matches[1][count($matches[1]) - 1];
        return ['schedule_id' => $id];
    }

    public function prepareScheduleData($data)
    {
        if ($data['monday_status'] == '1') {
            $data['monday_open'][0] = $data['monday_open_hour'];
            $data['monday_open'][1] = $data['monday_open_minute'];
            $data['monday_open_break'][0] = $data['monday_open_break_hour'];
            $data['monday_open_break'][1] = $data['monday_open_break_minute'];
            $data['monday_close_break'][0] = $data['monday_close_break_hour'];
            $data['monday_close_break'][1] = $data['monday_close_break_minute'];
            $data['monday_close'][0] = $data['monday_close_hour'];
            $data['monday_close'][1] = $data['monday_close_minute'];
        }
        if ($data['tuesday_status'] == '1') {
            $data['tuesday_open'][0] = $data['tuesday_open_hour'];
            $data['tuesday_open'][1] = $data['tuesday_open_minute'];
            $data['tuesday_open_break'][0] = $data['tuesday_open_break_hour'];
            $data['tuesday_open_break'][1] = $data['tuesday_open_break_minute'];
            $data['tuesday_close_break'][0] = $data['tuesday_close_break_hour'];
            $data['tuesday_close_break'][1] = $data['tuesday_close_break_minute'];
            $data['tuesday_close'][0] = $data['tuesday_close_hour'];
            $data['tuesday_close'][1] = $data['tuesday_close_minute'];
        }
        if ($data['wednesday_status'] == '1') {
            $data['wednesday_open'][0] = $data['wednesday_open_hour'];
            $data['wednesday_open'][1] = $data['wednesday_open_minute'];
            $data['wednesday_open_break'][0] = $data['wednesday_open_break_hour'];
            $data['wednesday_open_break'][1] = $data['wednesday_open_break_minute'];
            $data['wednesday_close_break'][0] = $data['wednesday_close_break_hour'];
            $data['wednesday_close_break'][1] = $data['wednesday_close_break_minute'];
            $data['wednesday_close'][0] = $data['wednesday_close_hour'];
            $data['wednesday_close'][1] = $data['wednesday_close_minute'];
        }
        if ($data['thursday_status'] == '1') {
            $data['thursday_open'][0] = $data['thursday_open_hour'];
            $data['thursday_open'][1] = $data['thursday_open_minute'];
            $data['thursday_open_break'][0] = $data['thursday_open_break_hour'];
            $data['thursday_open_break'][1] = $data['thursday_open_break_minute'];
            $data['thursday_close_break'][0] = $data['thursday_close_break_hour'];
            $data['thursday_close_break'][1] = $data['thursday_close_break_minute'];
            $data['thursday_close'][0] = $data['thursday_close_hour'];
            $data['thursday_close'][1] = $data['thursday_close_minute'];
        }
        if ($data['friday_status'] == '1') {
            $data['friday_open'][0] = $data['friday_open_hour'];
            $data['friday_open'][1] = $data['friday_open_minute'];
            $data['friday_open_break'][0] = $data['friday_open_break_hour'];
            $data['friday_open_break'][1] = $data['friday_open_break_minute'];
            $data['friday_close_break'][0] = $data['friday_close_break_hour'];
            $data['friday_close_break'][1] = $data['friday_close_break_minute'];
            $data['friday_close'][0] = $data['friday_close_hour'];
            $data['friday_close'][1] = $data['friday_close_minute'];
        }
        if ($data['saturday_status'] == '1') {
            $data['saturday_open'][0] = $data['saturday_open_hour'];
            $data['saturday_open'][1] = $data['saturday_open_minute'];
            $data['saturday_open_break'][0] = $data['saturday_open_break_hour'];
            $data['saturday_open_break'][1] = $data['saturday_open_break_minute'];
            $data['saturday_close_break'][0] = $data['saturday_close_break_hour'];
            $data['saturday_close_break'][1] = $data['saturday_close_break_minute'];
            $data['saturday_close'][0] = $data['saturday_close_hour'];
            $data['saturday_close'][1] = $data['saturday_close_minute'];
        }
        if ($data['sunday_status'] == '1') {
            $data['sunday_open'][0] = $data['sunday_open_hour'];
            $data['sunday_open'][1] = $data['sunday_open_minute'];
            $data['sunday_open_break'][0] = $data['sunday_open_break_hour'];
            $data['sunday_open_break'][1] = $data['sunday_open_break_minute'];
            $data['sunday_close_break'][0] = $data['sunday_close_break_hour'];
            $data['sunday_close_break'][1] = $data['sunday_close_break_minute'];
            $data['sunday_close'][0] = $data['sunday_close_hour'];
            $data['sunday_close'][1] = $data['sunday_close_minute'];
        }
        return $data;
    }
}