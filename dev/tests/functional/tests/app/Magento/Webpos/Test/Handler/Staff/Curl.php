<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 15:50:08
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-09-14 15:27:26
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Handler\Staff;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl extends AbstractCurl implements StaffInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'webposadmin/staff_staff/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        'customer_group' => [
            'All groups' => 'all',
            'General' => '1',
            'Wholesale' => '2',
            'Retailer' => '3'
        ],
        'status' => [
            'Enabled' => '1',
            'Disabled' => '2'
        ],
        'pos_ids' => [
            'Store POS' => '1'
        ],
        'location_id' => [
            'Store Address' => '1'
        ],
        'role_id' => [
            'admin' => '1'
        ]
    ];

    public function persist(FixtureInterface $fixture = null)
    {
        $data = $this->replaceMappingData($fixture->getData());
        $data = $this->prepareCustomerGroup($data);
        $data = $this->prepareLocation($data);
        $data = $this->preparePOS($data);
        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Staff entity creation by curl handler was not successful! Response: $response"
            );
        }

        $data['staff_id'] = $this->getStaffId($fixture->getEmail());
        return ['staff_id' => $data['staff_id']];
    }

    protected function getStaffId($email)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'webpos_staff_listing',
            'filters' => [
                'placeholder' => false,
                'email' => $email
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();

        preg_match('/webpos_staff_listing_data_source.+items.+"staff_id":"(\d+)"/', $response, $match);
        return empty($match[1]) ? null : $match[1];
    }

    protected function prepareCustomerGroup(array $data)
    {
        if (is_array($data['customer_group'])) {
            foreach ($data['customer_group'] as $key => $value) {
                if (!isset($this->mappingData['customer_group'][$value])) {
                    continue;
                }
                $data['customer_group'][$key] = $this->mappingData['customer_group'][$value];

            }
        } else {
            $data['customer_group'] = [$data['customer_group']];
        }
        return $data;
    }

    protected function prepareLocation(array $data)
    {
        if (is_array($data['location_id'])) {
            foreach ($data['location_id'] as $key => $value) {
                if (!isset($this->mappingData['location_id'][$value])) {
                    continue;
                }
                $data['location_id'][$key] = $this->mappingData['location_id'][$value];
            }
        } else {
            $array = array();
            $array[]= $data['location_id'];
            $data['location_id'] = $array;
        }
        return $data;
    }

    protected function preparePOS(array $data)
    {
        if (is_array($data['pos_ids'])) {
            foreach ($data['pos_ids'] as $key => $value) {
                if (!isset($this->mappingData['pos_ids'][$value])) {
                    continue;
                }
                $data['pos_ids'][$key] = $this->mappingData['pos_ids'][$value];
            }
        } else {
            $array = array();
            $array[]= $data['pos_ids'];
            $data['pos_ids'] = $array;
        }
        return $data;
    }
}
