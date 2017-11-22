<?php
/**
 * Copyright © 2017 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\Handler\Gifthistory;

use Magento\Backend\Test\Handler\Conditions;
use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\System\Event\EventManagerInterface;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

/**
 * Gifthistory Curl
 */
class Curl extends Conditions implements GifthistoryInterface
{
    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        'action' => [
            1 => 'Create',
            2 => 'Update',
            3 => 'Mass update',
            5 => 'Spent on order',
            6 => 'Refund',
            7 => 'Redeem',
        ],
        'status' => [
            1 => 'Pending',
            2 => 'Active',
            3 => 'Disabled',
            4 => 'Used',
            5 => 'Expired',
        ],
    ];
    
    /**
     * Url to get history list.
     *
     * @var string
     */
    protected $url = 'mui/index/render/?namespace=giftcard_history_listing&paging[pageSize]=1&paging[current]=1&sorting[field]=created_at&sorting[direction]=desc&isAjax=true';

    /**
     * Request for gift card history
     *
     * @param FixtureInterface $fixture
     * @return array
     * @throws \Exception
     */
    public function persist(FixtureInterface $fixture = null)
    {
        $url = $_ENV['app_backend_url'] . $this->url;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, [], CurlInterface::GET, [
            'Accept: application/json, text/javascript, */*; q=0.01',
        ]);
        $response = $curl->read();
        $curl->close();
        
        $data = \Zend_Json::decode($response);
        $item = $data['items'][0];
        
        // date
        $item['created_at'] = date('m/d/Y', strtotime($item['created_at']));
        
        return $this->replaceMappingData($item);
    }
}
