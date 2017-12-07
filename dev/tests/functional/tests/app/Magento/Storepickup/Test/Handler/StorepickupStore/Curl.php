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
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

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

        preg_match("`storepickup_id\/(\d*?)\/`", $response, $matches);
        $id = isset($matches[1]) ? $matches[1] : null;

        return ['storepickup_id' => $id];
    }
}