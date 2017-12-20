<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/6/2017
 * Time: 4:51 PM
 */

namespace Magento\Storepickup\Test\Handler\StorepickupStore;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;
use Magento\Setup\Exception;

class Curl extends AbstractCurl implements StorepickupStoreInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'storepickupadmin/store/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        'status' => [
            'Enabled' => '1',
            'Disabled' => '2'
        ],
        'country_id' => [
            'United States' => 'US',
            'United Kingdom' => 'GB',
            'Germany' => 'DE'
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

        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Store entity creation by curl handler was not successful! Response: $response"
            );
        }
        $data['storepickup_id'] = $this->getStoreId($fixture->getStoreName());

        return ['storepickup_id' => $data['storepickup_id']];
    }

    protected function getStoreId($storeName)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'storepickup_store_listing',
            'filters' => [
                'placeholder' => true,
                'store_name' => $storeName
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();
        preg_match('/storepickup_store_listing_data_source.+items.+"storepickup_id":"(\d+)"/', $response, $match);
        return empty($match[1]) ? null : $match[1];
    }
}