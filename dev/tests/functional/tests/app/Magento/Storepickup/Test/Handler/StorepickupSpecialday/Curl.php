<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 4:05 PM
 */

namespace Magento\Storepickup\Test\Handler\StorepickupSpecialday;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;
use Magento\Setup\Exception;

class Curl extends AbstractCurl implements StorepickupSpecialdayInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'storepickupadmin/specialday/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
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
        $data = $this->prepareSpecialdayData($data);
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
                "Store Specialday entity creation by curl handler was not successful! Response: $response"
            );
        }
        $data['specialday_id'] = $this->getSpecialdayId($fixture->getSpecialdayName());
        return ['specialday_id' =>  $data['specialday_id']];
    }

    protected function getSpecialdayId($specialdayName)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'storepickup_specialday_listing',
            'filters' => [
                'placeholder' => true,
                'specialday_name' => $specialdayName
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();
        preg_match('/storepickup_specialday_listing_data_source.+items.+"specialday_id":"(\d+)"/', $response, $match);
        return empty($match[1]) ? null : $match[1];
    }

    public function prepareSpecialdayData($data)
    {
        $data['time_open'][0] = $data['time_open_hour'];
        $data['time_open'][1] = $data['time_open_minute'];
        $data['time_close'][0] = $data['time_close_hour'];
        $data['time_close'][1] = $data['time_close_minute'];

        return $data;
    }
}