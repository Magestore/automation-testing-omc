<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/6/2017
 * Time: 8:35 AM
 */

namespace Magento\Webpos\Test\Handler\Denomination;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl  extends AbstractCurl implements DenominationInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'webposadmin/denomination/save/';

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
                "Denomination entity creation by curl handler was not successful! Response: $response"
            );
        }

        $data['denomination_id'] = $this->getDenominationId($fixture->getDenominationName());
        return ['denomination_id' => $data['denomination_id']];
    }

    /**
     * Get pos id by name
     *
     * @param string $name
     * @return int|null
     */
    protected function getDenominationId($name)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'webpos_denomination_listing',
            'filters' => [
                'placeholder' => true,
                'denomination_name' => $name
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();

        preg_match('/webpos_denomination_listing_data_source.+items.+"denomination_id":"(\d+)"/', $response, $match);
        return empty($match[1]) ? null : $match[1];
    }
}