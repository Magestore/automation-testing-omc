<?php
/**
 * Copyright © 2017 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\Handler\Giftcode;

use Magento\Backend\Test\Handler\Conditions;
use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\System\Event\EventManagerInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

/**
 * Giftcode Curl
 */
class Curl extends Conditions implements GiftcodeInterface
{
    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        'currency' => [
            'US Dollar' => 'USD',
        ],
        'status' => [
            'Pending' => 1,
            'Active' => 2,
            'Disabled' => 3,
            'Used' => 4,
            'Expired' => 5,
        ],
        'store_id' => [
            'All Store Views' => 0,
            'Default Store View' => 1,
        ],
    ];
    
    /**
     * Url for save gift code page.
     *
     * @var string
     */
    protected $url = 'giftvoucheradmin/giftvoucher/save/back/edit';

    /**
     * Post request for creating a giftcode
     *
     * @param FixtureInterface $fixture
     * @return array
     * @throws \Exception
     */
    public function persist(FixtureInterface $fixture = null)
    {
        $url = $_ENV['app_backend_url'] . $this->url;
        $data = $this->replaceMappingData($fixture->getData());
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->addOption(CURLOPT_HEADER, 1);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception("Gift code entity creating by curl handler was not successful! Response: $response");
        }
        
        $result = $fixture->getData();
        
        preg_match('/"data":({.*("giftvoucher_id":"(\d*?)")[^}]*})/', $response, $matches);
        if (isset($matches[3])) {
            $result['giftvoucher_id'] = $matches[3];
            preg_match('/"gift_code":"([^"]*)"/', $matches[1], $matches);
            $result['gift_code'] = isset($matches[1]) ? $matches[1] : 'TEST';
        }
        
        $result['extra_content'] = 'Created by admin';
        return $result;
    }
}
