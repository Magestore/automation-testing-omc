<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/18/2017
 * Time: 8:25 AM
 */

namespace Magento\InventorySuccess\Test\Handler\Warehouse;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl extends AbstractCurl implements WarehouseInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'inventorysuccess/warehouse/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [];

    /**
     * POST request for creating Synonym Group.
     *
     * @param FixtureInterface|null $fixture [optional]
     * @return array
     * @throws \Exception
     */
    public function persist(FixtureInterface $fixture = null)
    {

        $data = $fixture->getData();
        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Warehouse entity creation by curl handler was not successful! Response: $response"
            );
        }

        preg_match_all('/\"warehouse_id\":\"(\d+)\"/', $response, $matches);
        $id = $matches[1][count($matches[1]) - 1];
        return ['warehouse_id' => $id];
    }
}