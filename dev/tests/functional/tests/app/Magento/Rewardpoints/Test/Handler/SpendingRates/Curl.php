<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/6/2017
 * Time: 7:54 AM
 */

namespace Magento\Rewardpoints\Test\Handler\SpendingRates;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

/**
 * Class Curl
 * @package Magento\Rewardpoints\Test\Handler\SpendingRates
 */
class Curl extends AbstractCurl implements SpendingRatesInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'rewardpoints/spendingrates/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        'website_ids'  => [
            'Main Website' =>'1'
        ],
        'customer_group_ids'  => [
            'NOT LOGGED IN' => '0',
            'General'    => '1',
            'Wholesale'  => '2',
            'Retailer'   => '3'
        ],
        'status'  => [
            'Active'       => '1',
            'Inactive'      => '2'
        ]
    ];


    /**
     * Mapping values for Websites
     *
     * @var array
     */
    protected $websiteIds = [
        'Main Website' => 1,
    ];

    /**
     * Mapping values for Customer Groups
     *
     * @var array
     */
    protected $customerGroupIds = [
        'NOT LOGGED IN' => 0,
        'General' => 1,
        'Wholesale' => 2,
        'Retailer' => 3,
    ];

    public function persist(FixtureInterface $fixture = null)
    {
        $data = $this->prepareData($fixture);
        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Spending Rates entity creation by curl handler was not successful! Response: $response"
            );
        }
        preg_match_all("/rate_id\":\"(\d*?)\"/", $response, $matches);

        $id = isset($matches[1]) ? $matches[1][count($matches[1])-1] : null;

//        $data['rate_id'] = $fixture->getRateId();
        return ['rate_id' => $id];
    }


    protected function prepareData($rate)
    {
        $data = $this->replaceMappingData($rate->getData());
        $data['rewardpoints_spendingrates'] = $data;
        if (isset($data['website_ids'])) {
            $websiteIds = [];
            foreach ($data['website_ids'] as $websiteId) {
                $websiteIds[] = isset($this->websiteIds[$websiteId]) ? $this->websiteIds[$websiteId] : $websiteId;
            }
            $data['rewardpoints_spendingrates']['website_ids'] = $websiteIds;
        }
        if (isset($data['customer_group_ids'])) {
            $customerGroupIds = [];
            foreach ($data['customer_group_ids'] as $customerGroupId) {
                $customerGroupIds[] = isset($this->customerGroupIds[$customerGroupId])
                    ? $this->customerGroupIds[$customerGroupId]
                    : $customerGroupId;
            }
            $data['rewardpoints_spendingrates']['customer_group_ids'] = $customerGroupIds;
        }
        return $data;
    }
}