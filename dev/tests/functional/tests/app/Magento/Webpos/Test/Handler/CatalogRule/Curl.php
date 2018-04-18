<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/7/2018
 * Time: 4:09 PM
 */
namespace Magento\Webpos\Test\Handler\CatalogRule;

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
    protected $deleteUrl = 'catalog_rule/promo_catalog/delete/id/%d/';

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
                "Catalog Price Rule entity delete by curl handler was not successful! Response: $response"
            );
        }
    }
}