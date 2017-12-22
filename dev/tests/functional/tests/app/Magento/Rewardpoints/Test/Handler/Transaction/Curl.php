<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/6/2017
 * Time: 7:54 AM
 */

namespace Magento\Rewardpoints\Test\Handler\Transaction;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

/**
 * Class Curl
 * @package Magento\Rewardpoints\Test\Handler\Transactions
 */
class Curl extends AbstractCurl implements TransactionInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'rewardpoints/transaction/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [];


    public function persist(FixtureInterface $fixture = null)
    {
//        $data = $this->prepareData($fixture);
        $data = $fixture->getData();
        $customer = $fixture->getDataFieldConfig('customer_email')['source']->getCustomer();
        $data['customer_id'] = $customer->getId();
        $data['featured_customers'] = $customer->getEmail();
        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Location entity creation by curl handler was not successful! Response: $response"
            );
        }

//        $data['rate_id'] = $fixture->getRateId();
//        return ['rate_id' => $data['rate_id']];
    }


    protected function prepareData($transactions)
    {
        $data = $this->replaceMappingData($transactions->getData());
        return $data;
    }
}