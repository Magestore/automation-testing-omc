<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-08 11:17:14
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-08 11:22:53
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Handler\Pos;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl extends AbstractCurl implements PosInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'webposadmin/pos/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        'staff_id' => [
            'admin admin' => '1'
        ],
        'status' => [
            'Enabled' => '1',
            'Disabled' => '2'
        ],
        'location_id' => [
            'Store Address' => '1'
        ]
    ];

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
                "Pos entity creation by curl handler was not successful! Response: $response"
            );
        }

        $data['pos_id'] = $this->getPosId($fixture->getPosName());
        return ['pos_id' => $data['pos_id']];
    }

    /**
     * @param $name
     * @return null
     * @throws \Exception
     */
    protected function getPosId($name)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'webpos_pos_listing',
            'filters' => [
                'placeholder' => true,
                'pos_name' => $name
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();

        preg_match('/webpos_pos_listing_data_source.+items.+"pos_id":"(\d+)"/', $response, $match);
        return empty($match[1]) ? null : $match[1];
    }
}
