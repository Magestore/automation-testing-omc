<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/15/2018
 * Time: 2:13 PM
 */

namespace Magento\Webpos\Test\Handler\TaxRule;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

class Curl extends AbstractCurl
{
    /**
     * Url for delete data.
     *
     * @var string
     */
    protected $deleteUrl = 'tax/rule/delete/rule/%d/';

    public function persist(FixtureInterface $fixture = null)
    {
        $ruleId = $fixture->getData('id');
        $this->deleteUrl = sprintf($this->deleteUrl, $ruleId);
        $url = $_ENV['app_backend_url'] . $this->deleteUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url);
        $response = $curl->read();
        $curl->close();
         if (!strpos($response, 'data-ui-id="messages-message-success"')) {
             throw new \Exception(
                 "Tax Rule entity delete by curl handler was not successful! Response: $response"
             );
         }
    }
}