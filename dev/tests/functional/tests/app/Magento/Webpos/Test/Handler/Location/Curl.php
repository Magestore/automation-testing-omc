<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-05 16:23:29
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-14 15:21:07
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Handler\Location;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl extends AbstractCurl implements LocationInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'webposadmin/location/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [];

    public function persist(FixtureInterface $fixture = null)
    {
        $data = $this->replaceMappingData($fixture->getData());

        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Location entity creation by curl handler was not successful! Response: $response"
            );
        }

        $data['location_id'] = $this->getLocationId($fixture->getDisplayName());
        return ['location_id' => $data['location_id']];
    }

    /**
     * Get location id by name
     *
     * @param string $name
     * @return int|null
     */
    protected function getLocationId($name)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'webpos_location_listing',
            'filters' => [
                'placeholder' => true,
                'display_name' => $name
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();

        preg_match('/webpos_location_listing_data_source.+items.+"location_id":"(\d+)"/', $response, $match);
        return empty($match[1]) ? null : $match[1];
    }
}
