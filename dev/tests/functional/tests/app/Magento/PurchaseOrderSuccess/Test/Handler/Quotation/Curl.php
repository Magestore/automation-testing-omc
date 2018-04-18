<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/27/2017
 * Time: 11:00 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\Handler\Quotation;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;
use Magento\Setup\Exception;

/**
 * Class Curl
 * @package Magento\Rewardpoints\Test\Handler\Transactions
 */
class Curl extends AbstractCurl implements QuotationInterface
{
    /**
     * Url for saving data.
     *
     * @var string
     */
    protected $saveUrl = 'purchaseordersuccess/purchaseOrder/save/';

    /**
     * Mapping values for data.
     *
     * @var array
     */
    protected $mappingData = [
        'currency_code' => [
            'US Dollar' => 'USD',
            'Vietnamese Dong' => 'VND'
        ],
    ];


    public function persist(FixtureInterface $fixture = null)
    {
        $data = $this->replaceMappingData($fixture->getData());
        $supplier = $fixture->getDataFieldConfig('supplier_id')['source']->getSupplier();
        $data['supplier_id'] = $supplier->getSupplierId();
//        $data['purchased_at'] = $supplier->getCreatedAt();
        $data['purchased_at'] = "2017-12-28";
        $data['type'] = "1";
//        throw new Exception(var_dump($data));
        $url = $_ENV['app_backend_url'] . $this->saveUrl;
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();
        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception(
                "Quotation entity creation by curl handler was not successful! Response: $response"
            );
        }
        preg_match_all("/purchase_code\":\"(\w*?)\"/", $response, $matches);
        preg_match_all("/purchase_order_id\":\"(\d*?)\"/", $response, $matches1);
        $code = $matches[1][0];
        $purchase_order_id = $matches1[1][0];
//        throw new Exception(var_dump($purchase_order_id));

        return ['purchase_code' => $code, 'purchase_order_id' => $purchase_order_id];
    }

}