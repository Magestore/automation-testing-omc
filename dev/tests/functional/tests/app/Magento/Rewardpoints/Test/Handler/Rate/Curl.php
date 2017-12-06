<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/6/2017
 * Time: 7:54 AM
 */

namespace Magento\Rewardpoints\Test\Handler\Rate;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

/**
 * Class Curl
 * @package Magento\Rewardpoints\Test\Handler\Rate
 */
class Curl extends AbstractCurl implements RateInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'rewardpoints/earningrates/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        'website_ids'  => [
            'Main Website' => '1',
        ],
        'customer_group'  => [
            'All groups' => 'all',
            'General'    => '1',
            'Wholesale'  => '2',
            'Retailer'   => '3'
        ],
        'status'  => [
            'Enabled'       => '1',
            'Disabled'      => '2'
        ]
    ];

    /**
     * @param FixtureInterface|null $fixture
     * @return array
     */
    public function persist(FixtureInterface $fixture = null)
    {
        $data = $this->replaceMappingData($fixture->getData());
        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
//        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
//            throw new \Exception(
//                "Location entity creation by curl handler was not successful! Response: $response"
//            );
//        }

        $data['rate_id'] = $fixture->getRateId();
        return ['rate_id' => $data['rate_id']];
    }


    /**
     * @param FixtureInterface $rate
     * @return mixed
     */
    protected function prepareData(FixtureInterface $rate)
    {
        // Replace UI fixture values with values that are applicable for cURL. Property $mappingData is used.
        $data = $this->replaceMappingData($rate->getData());
        // Perform data manipulations to prepare the cURL request based on input data.

        return $data;
    }
    // Additional methods.
}