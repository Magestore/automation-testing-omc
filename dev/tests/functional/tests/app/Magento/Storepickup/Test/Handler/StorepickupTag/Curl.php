<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/7/2017
 * Time: 2:39 PM
 */

namespace Magento\Storepickup\Test\Handler\StorepickupTag;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;
use Magento\Setup\Exception;

class Curl extends  AbstractCurl implements StorepickupTagInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'storepickupadmin/tag/save/active_tab/stores_section/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [];

    /**
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
                "Store Tag entity creation by curl handler was not successful! Response: $response"
            );
        }
        $data['tag_id'] = $this->getTagId($fixture->getTagName());
        return ['tag_id' => $data['tag_id']];
    }

    protected function getTagId($tagName)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'storepickup_tag_listing',
            'filters' => [
                'placeholder' => true,
                'tag_name' => $tagName
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();
        preg_match('/storepickup_tag_listing_data_source.+items.+"tag_id":"(\d+)"/', $response, $match);
        throw new Exception(var_dump($match[1]));
        return empty($match[1]) ? null : $match[1];
    }
}