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
        $dataProduct = $this->getDataProduct($fixture->getProductSku());
        $dataProducts = [];
//        for($i = 0; $i < count($products); ++$i) {
//            $dataProducts[$i] = [
//                "id" => $products[$i]["id"],
//                "name" => $products[$i]["name"],
//                "sku" => $products[$i]["sku"],
//                "price" => $products[$i]["price"],
//                "status" => "Enabled" ,
//                "attribute_set" => $products[$i]["attribute_set_id"],
//                "thumbnail" => "",
//                "position" => $i,
//                "supplier" => "",
//                "record_id" => $products[$i]["id"]
//            ];
//        }
        $dataProducts[0] = [
                "id" => $dataProduct['id'],
                "name" => "",
                "sku" => $fixture->getProductSku(),
                "price" => "",
                "status" => "Enabled" ,
                "attribute_set" => "",
                "thumbnail" => "",
                "position" => "",
                "supplier" => $fixture->getSupplierCode(),
                "record_id" => ""
            ];
        $data = [
            "links" => [
                "selected_products" => $dataProducts
            ],
            "general_information" => [
                "reason" => "Test"
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
        $barcode = $this->getBarcodeId($fixture->getProductSku())['barcode'];
        $id = $this->getBarcodeId($fixture->getProductSku())['id'];
        return ['product_sku' => $fixture->getProductSku(),
                'barcode' => $barcode,
                'supplier_code' => $fixture->getSupplierCode(),
                'id' => $id,
                'username' => 'admin',
                'type' => 'Generated'
                ];
    }

    protected function getDataProduct($sku)
    {
        $url = $_ENV['app_backend_url'] . 'mui/index/render/';
        $data = [
            'namespace' => 'product_listing',
            'filters' => [
                'placeholder' => true,
                'sku' => $sku
            ],
            'isAjax' => true
        ];
        $curl = new BackendDecorator(new CurlTransport(), $this->_configuration);

        $curl->write($url, $data, CurlInterface::POST);
        $response = $curl->read();
        $curl->close();
        preg_match('/product_listing.+items.+"entity_id":"(\d+)"/', $response, $matchId);
        return [
            "id" => empty($matchId[1]) ? null : $matchId[1],
            "sku" => "abc123defghj"
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