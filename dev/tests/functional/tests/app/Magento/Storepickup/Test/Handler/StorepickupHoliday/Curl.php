<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 5:32 PM
 */

namespace Magento\Storepickup\Test\Handler\StorepickupHoliday;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
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
     * POST request for creating Synonym Group.
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

        preg_match_all('/\"holiday_id\":\"(\d+)\"/', $response, $matches);
        $id = $matches[1][count($matches[1]) - 1];
        return ['holiday_id' => $id];
    }
}