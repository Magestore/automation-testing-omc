<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/26/2017
 * Time: 7:48 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Handler\Supplier;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl extends AbstractCurl implements SupplierInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'suppliersuccess/supplier/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        'status' => [
            'Enable' => '1',
            'Disable' => '0'
        ],
        'country_id' => [
            'United States' => 'US',
            'United Kingdom' => 'GB',
            'Germany' => 'DE'
        ],
        'region_id' => [
            'California' => 12,
            'New York' => 43,
            'Texas' => 57,
        ],
        'generated_password' => [
            'Yes' => '1',
            'No' => '0'
        ],
        'send_pass_to_supplier' => [
            'Yes' => '1',
            'No' => '0'
        ]
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
                "Supplier entity creation by curl handler was not successful! Response: $response"
            );
        }
        preg_match('/supplier_id":"(\d+)"/', $response, $match);
        $data['supplier_id'] = $match[1];
        return ['supplier_id' =>  $data['supplier_id']];
    }
}