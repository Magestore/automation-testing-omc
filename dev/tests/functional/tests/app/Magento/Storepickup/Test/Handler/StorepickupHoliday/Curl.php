<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 5:32 PM
 */

namespace Magento\Storepickup\Test\Handler\StorepickupHoliday;

use Magento\Framework\Webapi\Exception;
use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl extends AbstractCurl implements StorepickupHolidayInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'storepickupadmin/holiday/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [];

    /**
     *
     * @param FixtureInterface|null $fixture [optional]
     * @return array
     * @throws \Exception
     */
    public function persist(FixtureInterface $fixture = null)
    {

        $data = $fixture->getData();
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
                "Store Holiday entity creation by curl handler was not successful! Response: $response"
            );
        }
        $data['holiday_id'] = $this->getHolidayId($fixture->getHolidayName());
        return ['holiday_id' =>  $data['holiday_id']];
    }

    protected function getHolidayId($holidayName)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'storepickup_holiday_listing',
            'filters' => [
                'placeholder' => true,
                'holiday_name' => $holidayName
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();
        preg_match('/storepickup_holiday_listing_data_source.+items.+"holiday_id":"(\d+)"/', $response, $match);
        return empty($match[1]) ? null : $match[1];
    }
}