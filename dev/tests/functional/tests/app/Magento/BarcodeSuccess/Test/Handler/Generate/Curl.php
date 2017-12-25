<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 11/12/2017
 * Time: 23:20
 */
namespace Magento\BarcodeSuccess\Test\Handler\Generate;

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Handler\Curl as AbstractCurl;
use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\System\Event\EventManagerInterface;
use Magento\Mtf\Util\Protocol\CurlInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\TestFramework\Inspection\Exception;

class Curl extends AbstractCurl
{
    public function persist(FixtureInterface $fixture = null)
    {
        $products = $fixture->getDataFieldConfig('products')['source']->getDataProducts();
        for($i = 0; $i < count($products); ++$i) {
            $dataProducts[$i] = [
                "id" => $products[$i]["id"],
                "name" => $products[$i]["name"],
                "sku" => $products[$i]["sku"],
                "price" => $products[$i]["price"],
                "status" => "Enabled" ,
                "attribute_set" => $products[$i]["attribute_set_id"],
                "thumbnail" => "",
                "position" => $i,
                "supplier" => $products[$i]["sku"],
                "record_id" => $products[$i]["id"]
            ];
        }
        $data = [
            "links" => [
                "selected_products" => $dataProducts
            ],
            "general_information" => [
                "reason" => $fixture->getReason()
            ],

        ];
//        throw new \Exception($fixture->getProductSku());
        $url = $_ENV['app_backend_url'] . 'barcodesuccess/index/save/';
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);
        $curl->write($url, $data);
        $response = $curl->read();
        $curl->close();

        if (!strpos($response, 'data-ui-id="messages-message-success"')) {
            throw new \Exception("The barcode has been saved successfully! Response: $response");
        }
        $barcode = $this->getBarcodeId($products[0]["sku"])['barcode'];
        $id = $this->getBarcodeId($products[0]["sku"])['id'];
        return ['product_sku' => $products[0]["sku"],
                'barcode' => $barcode,
                'supplier_code' => $products[0]["sku"],
                'id' => $id,
                'username' => 'admin',
                'type' => 'Generated'
                ];
    }
    protected function getBarcodeId($sku)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'os_barcode_listing',
            'filters' => [
                'placeholder' => true,
                'product_sku' => $sku
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();
        preg_match('/os_barcode_listing.+items.+"id":"(\d+)"/', $response, $matchId);
        preg_match('/os_barcode_listing.+items.+"barcode":"(\d+)"/', $response, $matchBarcode);

        return [
            'id' => empty($matchId[1]) ? null : $matchId[1],
            'barcode' => empty($matchBarcode[1]) ? null : $matchBarcode[1]
        ];
    }
}